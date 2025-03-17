@extends('sidebar.app')


<body style="background-color:#f8f9fa;">
    @section('content')
        @include('libraries.scripts')
        <div class="content flex-grow-1" style="padding: 20px;">
            <div class="container">
                <h3 align="center">Update Product</h3>
                <div class="row">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-12">


                        <div class="form-area" id="productForm">

                            <form method="POST" action="{{ route('product.update', $product->id) }}">
                                {!! csrf_field() !!}
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Product Code</label>
                                        <input type="text" readonly class="form-control" name="productcode"
                                            value="{{ $product->productcode }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Supplier</label>
                                        <select name="supplier_id" id="supplier_id" class="form-control">
                                            @foreach ($suppliers as $id => $supplier_fullname)
                                                <option value="{{ $id }}"
                                                    {{ $product->supplier_id == $id ? 'selected' : '' }}>
                                                    {{ $supplier_fullname }}
                                                </option>
                                            @endforeach
                                        </select>
                                     
                                    </div>
                                    <div class="col-md-3">
                                        <label>Product Name</label>
                                        <input type="text" class="form-control" name="productname"
                                            value="{{ $product->productname }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Quantity</label>
                                        <div class="d-flex">
                                            <input type="text" class="form-control " name="read_quantity"
                                                value="{{ $product->quantity }}" readonly>
                                            <input type="text" class="form-control" name="quantity" 
                                                >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Gold Type</label>
                                        
                                        <input type="text" class="form-control" name="gold_type" id="gold_type" value="{{ $product->gold_type }}" readonly>
                                        
                                        
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label>Cost Per Grams</label>
                                        <input type="text" class="form-control" name="cost_per_gram" id="cost_per_gram"
                                            value="{{ $product->cost_per_gram }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Price Per Grams</label>
                                        <input type="text" class="form-control" name="price_per_gram" id="price_per_gram"
                                            value="{{ $product->price_per_gram }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Grams</label>
                                        <input type="text" class="form-control" name="grams" id="grams"
                                            value="{{ $product->grams }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Cost Price</label>
                                        <input type="text" class="form-control" name="cost" id="cost_price"
                                            value="{{ $product->cost }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Selling Price</label>
                                        <input type="text" class="form-control" name="price" id="selling_price"
                                            value="{{ $product->price }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <input type="submit" class="btn btn-warning" value="Update Product">
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    @endsection

    @push('css')
        <style>
            .form-area {
                padding: 20px;
                margin-top: 20px;
                background-color: #F1F0E8;
            }

            ul {
                list-style: none;
            }
        </style>
    @endpush

    @include('libraries.productedit')
