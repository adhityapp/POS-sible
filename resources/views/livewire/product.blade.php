@section('title', 'Products')
<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="font-weight-bold mb-3 text-center">Product List</h2>
                        <table class="table table-bordered table-hovered table-strip">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th width="20%">Image</th>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index=>$product)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$product->name}}</td>
                                <td><img src="{{asset('storage/images/'. $product->image)}}" alt="product image" class="img-fluid"></td>
                                <td>{{$product->description}}</td>
                                <td>{{$product->qty}}</td>
                                <td>{{$product->price}}</td>
                                <td>
                                    <div class="row">
                                        <div class="ml-2 mr-2">
                                            <form action="" method="POST">
                                                @method('get')
                                                @csrf
                                                <button class ="btn btn-success d-inline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                        <div>
                                            <form action="" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button class ="btn btn-danger d-inline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>    
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="font-weight-bold mb-3 text-center">Create Product</h2>
                        <form wire:submit.prevent="store" action="">
                            <div class="form-group">
                                <label for="">Product Name</label>
                                <input wire:model="name" type="text" class="form-control">
                                @error('name')
                                    <small class="text-danger">{{$message}}</small>                                    
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Product Image</label>
                                <div class="custom-file">
                                    <label for="customFile" class="custom-file-label">Choose Image</label>
                                    <input wire:model="image" type="file" class="custom-file-input" id="customFile">
                                    @error('image')
                                        <small class="text-danger">{{$message}}</small>                                    
                                    @enderror
                                </div>
                                @if ($image)
                                    <label for="" class="mt-2">Image Preview</label>
                                    <img src="{{$image->temporaryUrl()}}" class="img-fluid" alt="Preview Image">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea wire:model="description" class="form-control"></textarea>
                                @error('description')
                                    <small class="text-danger">{{$message}}</small>                                    
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Quantity</label>
                                <input wire:model="qty" type="number" class="form-control">
                                @error('qty')
                                    <small class="text-danger">{{$message}}</small>                                    
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Price</label>
                                <input wire:model="price" type="number" class="form-control">
                                @error('price')
                                    <small class="text-danger">{{$message}}</small>                                    
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Submit Product</button>
                            </div>
                        </form>
                </div>
            </div> 
        </div>
    </div>
</div>
