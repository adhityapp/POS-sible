@section('title', 'Orders')
<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <h2 class="font-weight-bold mb-3">Products List</h2>
                        </div>
                        <div class="col-md-6">
                            <input wire:model="search" type="text" class="form-control" placeholder="Search Product...">
                        </div>
                    </div>
                    <div class="row">
                        @forelse ($products as $product)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body embed-responsive embed-responsive-16by9">
                                    <img src="{{asset('storage/images/'. $product->image)}}" alt="product" class="img-fluid embed-responsive-item">
                                </div>
                                <div class="card-footer">
                                    <h6 class="font-weight-bold text-center">{{$product->name}}</h6>
                                    <div class="text-center">
                                        <label for="">Rp {{number_format($product->price,2,',','.')}}</label>
                                    </div>
                                    <button wire:click="addItem({{$product->id}})" class="btn btn-primary btn-sm btn-block">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-sm-12 mt-5">
                            <h2 class="text-center font-weight-bold text-primary">No Products Found</h2>
                        </div>
                        @endforelse
                    </div>
                    <div style="display:flex;justify-content:center">
                        {{$products->links()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-3 text-center">Cart</h2>
                    <p class="text-danger">
                        @if (session()->has('error'))
                            {{session('error')}}                            
                        @endif
                    </p>
                    <table class="table table-sm table-bordered table-hovered">
                        <thead class="thead-dark text-white">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th class="text-center">Qty</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($carts as $index=>$cart)
                                <tr>
                                    <td>{{$index+1}}</td>
                                    <td>{{$cart['name']}}</td>
                                    <td class="text-center">
                                        <a href="#" wire:click="decreaseItem('{{$cart['rowId']}}')" class="font-weight-bold text-secondary" style="font-size: 18px">< </a>
                                        {{$cart['quantity']}}
                                        <a href="#" wire:click="increaseItem('{{$cart['rowId']}}')" class="font-weight-bold text-secondary" style="font-size: 18px"> ></a>
                                    </td>
                                    <td>Rp {{number_format($cart['price'],2,',','.')}}</td>
                                    {{-- <td>
                                        <button wire:click="deleteCart('{{$cart['rowId']}}')" class ="btn btn-danger d-inline">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                        </button>
                                    </td> --}}
                                </tr>
                            @empty
                                <td colspan="3"><h6 class="text-center">Empty Cart</h6></td>
                            @endforelse
                            <tr class="bg-dark">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Sub Total</td>
                                <td></td>
                                <td >Rp {{number_format($summary['subtotal'],2,',','.')}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Tax</td>
                                <td></td>
                                <td >Rp {{number_format($summary['pajak'],2,',','.')}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Total</td>
                                <td></td>
                                <td class="bg-success">Rp {{number_format($summary['total'],2,',','.')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div>
                        <button wire:click="enableTax" class="btn btn-primary btn-block">Add Tax</button>
                        <button wire:click="disableTax" class="btn btn-danger btn-block">Remove Tax</button>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-success btn-block">Save Transaction</button>
                        <button wire:click="deleteCart" class="btn btn-danger btn-block">Delete Transaction</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>