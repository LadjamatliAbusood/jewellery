@extends('layout.user')
@section('title', '3A Jewelery')
@include('libraries.scripts')

<body style="background-color:#f8f9fa;">
    @section('contents')
        <div class="content">

            <div class="col-md-12">
                <h4 class="text-center">Transaction<br>
                    {{ \Carbon\Carbon::parse($filterDate)->format('F j, Y') }} <!-- Display selected date -->

                </h4>
                <div class="row mt-4" style="display: flex; justify-content: center; align-items: center;">
                    <!-- Example Dashboard Cards -->
                    <div class="col-md-2">
                        <div class="card text-white bg-secondary mb-3">
                            <div class="card-header  text-center">
                                <h5>Quantity<h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-center">{{ $totalSalesQty }}</h4>

                            </div>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header  text-center">
                                <h5>Sales<h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-center">₱ {{ number_format($totalSales, 2) }}</h4>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header  text-center">
                                <h5>Expenses<h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-center">₱ {{ number_format($totalExpenses, 2) }}</h4>

                            </div>
                        </div>
                    </div>

                    {{-- Layaway --}}
                    <div class="col-md-2">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header text-center">
                                <h5>Lay Away<h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-center">
                                    {{ $totalLayaway }}
                                </h4>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="d-flex justify-content-end">
                    <form method="GET" action="">
                        <div class="text-end">
                            <label for="datePicker" class="form-label d-block">Select Date:</label>
                            <div class="d-flex">
                                <input type="date" id="datePicker" name="filter_date" class="form-control w-auto"
                                    value="{{ $filterDate }}">
                                <button type="submit" class="btn btn-primary ms-2">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Account</th>
                                <th scope="col">Product Code</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Grams</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Selling Price</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($SalesDetails as $key => $salesD)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $salesD->account }}</td>
                                    <td>{{ $salesD->sales_productcode }}</td>
                                    <td>{{ $salesD->productname }}</td>
                                    <td>{{ $salesD->grams }}</td>
                                    <td>{{ $salesD->qty }}</td>

                                    <td>{{ $salesD->price }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $SalesDetails->appends(['filter_date' => $filterDate])->links('pagination::bootstrap-5') }}
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
