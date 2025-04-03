@extends('admin.admin') <!-- Extends the base admin layout -->

<body style="background-color:#f8f9fa;">
    @section('content')
        <!-- Defines the content section -->

        <div class="content p-3">
            <div class="container">
                <!-- Dashboard Header -->
                <h3 class="text-center mt-1">
                    {{ now('Asia/Manila')->format('F j, Y h:i A') }}
                </h3>

                <div class="row mt-4 justify-content-center">
                    <!-- Example Dashboard Cards -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header text-center">
                                <h5>Available Stocks</h5>
                            </div>
                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $totalQuantity }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="card text-white bg-secondary mb-3">
                            <div class="card-header text-center">
                                <h5>Sales Quantity</h5>
                            </div>
                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $totalSalesQty }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-header text-center">
                                <h5>Cost</h5>
                            </div>
                            <div class="card-body text-center">
                                <h4 class="card-title">₱ {{ number_format($totalCost) }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header text-center">
                                <h5>Sales</h5>
                            </div>
                            <div class="card-body text-center">
                                <h4 class="card-title">₱ {{ number_format($totalSales) }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header text-center">
                                <h5>Gross Income</h5>
                            </div>
                            <div class="card-body text-center">
                                <h4 class="card-title">₱ {{ number_format($totalProfit) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 justify-content-center">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header text-center">
                                <h5>Expenses</h5>
                            </div>
                            <div class="card-body text-center">
                                <h4 class="card-title">₱ {{ number_format($totalExpenses) }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header text-center">
                                <h5>Lay Away</h5>
                            </div>
                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $totalLayaway }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Placeholder for Table or Charts -->
                <div class="row mt-4">
                    @include('dashboard.dashtable')
                </div>
            </div>
        </div>
    @endsection
</body>
