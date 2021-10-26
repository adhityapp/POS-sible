<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product as ProductModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;


class Order extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $tax = "0%";

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // $products = ProductModel::orderBy('created_at', 'DESC')->get();
        $products = ProductModel::where('name', 'like', '%' . $this->search . '%')->orderBy('created_at', 'DESC')->paginate(4);

        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'pajak',
            'type' => 'tax',
            'target' => 'total',
            'value' => $this->tax,
            'order' => 1,
        ]);

        \Cart::Session(Auth::id())->condition($condition);
        $items = \Cart::Session(Auth::id())->getContent()->sortBy(function ($cart) {
            return $cart->attributes->get('added at');
        });

        if (\Cart::isEmpty()) {
            $cartData = [];
        } else {
            foreach ($items as $item) {
                $cart[] = [
                    'rowId' => $item->id,
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'pricesingle' => $item->price,
                    'price' => $item->getPriceSum(),
                ];
            }
            $cartData = collect($cart);
        }

        $subtotal = \Cart::session(Auth::id())->getSubTotal();
        $total = \Cart::session(Auth::id())->getTotal();

        $newCondition = \Cart::session(Auth::id())->getCondition('pajak');
        $pajak = $newCondition->getCalculatedValue($subtotal);

        $summary = [
            'subtotal' => $subtotal,
            'pajak' => $pajak,
            'total' => $total,
        ];

        return view('livewire.order', [
            'products' => $products,
            'carts' => $cartData,
            'summary' => $summary,
        ]);
    }

    public function addItem($id)
    {
        $rowId = "Cart" . $id;
        $cart = \Cart::Session(Auth::id())->getContent();
        $cekItemId = $cart->whereIn('id', $rowId);
        $product = ProductModel::findOrFail($id);

        if ($cekItemId->isNotEmpty()) {
            if ($product->qty + 1 == $cekItemId[$rowId]->quantity) {
                session()->flash('error', 'Jumlah item kurang!');
            } else {
                \Cart::session(Auth::id())->update($rowId, [
                    'quantity' => 1,
                ]);
            }
        } else {

            \Cart::session(Auth::id())->add([
                'id' => "Cart" . $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => [
                    'added at' => Carbon::now()
                ],
            ]);
        }
    }

    public function enableTax()
    {
        $this->tax = "+10%";
    }

    public function disableTax()
    {
        $this->tax = "0%";
    }

    public function deleteCart($id)
    {
        \Cart::session(Auth::id())->remove($id);
    }

    public function increaseItem($id)
    {
        $idProduct = substr($id, 4, 5);
        $product = ProductModel::find($idProduct);
        $cart = \Cart::Session(Auth::id())->getContent();
        $cekItemId = $cart->whereIn('id', $id);

        if ($product->qty + 1 == $cekItemId[$id]->quantity) {
            session()->flash('error', 'Jumlah item kurang!');
        } else {
            \Cart::Session(Auth::id())->update($id, [
                'quantity' => 1,
            ]);
        };
    }

    public function decreaseItem($id)
    {
        \Cart::Session(Auth::id())->update($id, [
            'quantity' => -1,
        ]);

        $cart = \Cart::Session(Auth::id())->getContent();
        $cekItemId = $cart->whereIn('id', $id);


        if ($cekItemId[$id]->quantity - 1 == 0) {
            $this->deleteCart($id);
        }
    }
}
