
@extends('layout.user')

<body style="background-color:#f8f9fa;">
    @section('contents')
        @include('libraries.scripts')

        <div class="content">

            <div class="container-fluid mt-2">

        <div class="content" id="main-content" style=" padding: 20px; transition: 0.3s;">

            <div class="container-fluid">
                <h3 align="center">Add Product</h3>
                <div class="row">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-12">
                   

                        <div class="form-area" id="productForm">

                            <form method="POST" action="add-product">


                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Product Code</label>
                                        <input type="text" readonly class="form-control" name="productcode">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Supplier</label>
                                        <select name="supplier_id" id="supplier_id" class="form-control">
                                            @foreach ($suppliers as $id => $supplier_fullname)
                                                <option value="{{ $id }}">{{ $supplier_fullname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Product Name</label>
                                        <input type="text" class="form-control" name="productname">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Quantity</label>
                                        <input type="text" class="form-control" name="quantity" readonly value="1">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Gold Type</label>                              
                                        <select name="gold_id" id="gold_id" class="form-control">
                                            @foreach ($gold as $item)
                                                <option value="{{ $item->id }}" 
                                                    data-gold-cost="{{ $item->gold_cost }}"
                                                     data-gold-price="{{ $item->gold_price }}">
                                                    {{ $item->gold_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                    <div class="col-md-3">
                                        <label>Grams</label>
                                        <input type="text" class="form-control" name="grams" id="grams">
                                    </div>
                                
                                    <div class="col-md-3">
                                        <label>Selling Price</label>
                                        <input type="text" class="form-control" name="price" id="selling_price"
                                        readonly>
                                    </div>
                                    <div class="col-md-3">                                     
                                        <input type="text" class="form-control" name="cost" id="cost_price" hidden>                                  
                                         <input type="text" class="form-control" name="cost_per_gram" id="cost_per_gram" readonly
                                        hidden> 
                                        <input type="text" class="form-control" name="price_per_gram" id="price_per_gram" readonly
                                        hidden>
                                    </div>
                                
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <input type="submit" class="btn btn-primary" value="Add Product">
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- Search Input -->
                        <div class="row mb-3">
                            <!-- Search Input -->
                            <div class="col-md-6 ms-auto">

                                <input type="text" class="form-control mt-2" name="search" id="search"
                                    placeholder="Search.....">
                            </div>
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-hover float-end">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Product Code</th>
                                            <th scope="col">Supplier</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Gold Type</th>
                                            <th scope="col">Quantity</th>

                                            <th scope="col">Grams</th>
                                            <th scope="col">Selling Price</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                            <tr>
                                                <td scope="col">{{ ++$key }}</td>
                                                <td scope="col">{{ $product->productcode }}</td>
                                                <td scope="col">{{ $product->supplier->supplier_fullname }}</td>
                                              
                                                <td scope="col">{{ $product->productname }}</td>
                                                <td scope="col"> {{ $product->gold->gold_type }}</td>
                                                <td scope="col">{{ $product->quantity }}</td>

                                                <td scope="col">{{ $product->grams }}</td>
                                                <td scope="col">{{ number_format( $product->price,2) }}</td>
                                        
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{-- Uncomment this line if you have pagination enabled --}}
                                {{ $products->links('pagination::bootstrap-5') }}
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

            
        @include('libraries.productscripts')
