@extends('admin.admin') <!-- Extends the base admin layout -->


<body style="background-color:#f8f9fa;">
    @section('content')
        <!-- Defines the content section -->

        <div class="content" style="padding: 20px;  ">
            <div class="container">
                <!-- Dashboard Header -->
                <h3 align="center" class="mt-1">

                    {{ now('Asia/Manila')->format('F j, Y h:i A') }}</h3>

                <div class="row mt-4" style="display: flex; justify-content: center; align-items: center;">
                    <!-- Example Dashboard Cards -->
                    <div class="col-md-2">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header  text-center">
                                <h5>Available Stocks<h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-center">{{ $totalQuantity }}</h4>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card text-white bg-secondary mb-3">
                            <div class="card-header text-center">
                                <h5>Sales Quantity<h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-center">
                                    {{ $totalSalesQty }} <br>


                                </h4>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-header  text-center">
                                <h5>Cost <h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-center">
                                    ₱ {{ number_format($totalCost, 2) }}
                                </h4>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header text-center">
                                <h5>Sales<h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-center">
                                    ₱ {{ number_format($totalSales, 2) }}


                                </h4>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header text-center">
                                <h5>Gross Income<h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-center">

                                    ₱ {{ number_format($totalProfit, 2) }}

                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 " style="display: flex; justify-content: center; align-items: center;">

                    <div class="col-md-2">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header text-center">
                                <h5>Expenses<h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title text-center"> ₱ {{ number_format($totalExpenses, 2) }} </h4>
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
                {{-- <!-- Date Filter Form -->
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
            </div> --}}
                <!-- Placeholder for Table or Charts -->
                <div class="row mt-4">
                    @include('dashboard.dashtable')
                </div>
            </div>
        </div>
    @endsection
</body>
