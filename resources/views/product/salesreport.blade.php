@extends('admin.admin')

<body style="background-color:#f8f9fa;">
    @section('content')
        @include('libraries.scripts')

        <div class="content" id="main-content" style="padding: 20px; text-align: center;">


            <div class="container-fluid text-center">
                <h3 class="text-center">Sales Report</h3>

                <div class="row mt-5" style="display: flex; justify-content: center; align-items: center;">
                    <!-- Example Dashboard Cards -->


                    <div class="col-md-2">
                        <div class="card text-white bg-secondary mb-3">
                            <div class="card-header text-center">
                                <h5> Quantity<h5>
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
                                    {{ $totalLayawawy }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center mb-4">
                    <!-- Date Filter Form -->
                    <form method="GET" action="" class="d-flex align-items-center">

                        <div class="form-group me-3">

                            <input type="date" id="dateFromPicker" name="date_from" class="form-control"
                                value="{{ $dateFrom }}">
                        </div>

                        <div class="form-group me-3">

                            <input type="date" id="dateToPicker" name="date_to" class="form-control"
                                value="{{ $dateTo }}">
                        </div>

                        <button type="submit" class=" form-control btn btn-primary ms-2">Filter</button>


                        <!-- Ensure no div wraps this button -->
                    </form>

                    <!-- Download Excel Button -->
                    <form method="GET" action="{{ route('export.sales') }}" class="d-flex align-items-center ms-3">
                        <input type="hidden" name="date_from" value="{{ $dateFrom }}">
                        <input type="hidden" name="date_to" value="{{ $dateTo }}">
                        <button type="submit" class="btn btn-success">Download Excel</button>
                    </form>
                </div>



                <!-- Search Input -->
                <div class="row mb-3">
                    <!-- Search Input -->
                    <div class="col-md-6 ms-auto">
                        <input type="text" class="form-control" name="search" id="search" placeholder="Search...">
                    </div>


                    <!-- Download Excel Button -->


                    <!-- Responsive Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Account</th>
                                    <th scope="col">Product Code</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Grams</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Cost Price</th>
                                    <th scope="col">Selling Price</th>

                                    {{-- <th scope="col">Total</th> --}}
                                    <th scope="col">Gross Income</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($SalesDetails as $key => $salesD)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ \Carbon\Carbon::parse($salesD->created_at)->format('M d, Y')}}</td>
                                        
                                        <td>{{ $salesD->account }}</td>
                                        <td>{{ $salesD->productcode }}</td>
                                        <td>{{ $salesD->productname }}</td>
                                        <td>{{ $salesD->grams }}</td>
                                        <td>{{ $salesD->qty }}</td>
                                        <td>{{ number_format( $salesD->cost )}}</td>
                                        <td>{{ number_format( $salesD->price )}}</td>

                                        {{-- <td>{{ $salesDetail->total_cost }}</td> --}}
                                        <td>{{ number_format( $salesD->net_sale) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">

                        {{ $SalesDetails->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
</body>
@push('js')
    <script>
        //Search function
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('search').addEventListener('input', function() {
                const searchQuery = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const productCode = row.querySelector('td:nth-child(2)').textContent
                        .toLowerCase();
                    const productName = row.querySelector('td:nth-child(3)').textContent
                        .toLowerCase();
                    const productSupplier = row.querySelector('td:nth-child(4)').textContent
                        .toLowerCase();

                    if (productName.includes(searchQuery) || productCode.includes(searchQuery) ||
                        productSupplier.includes(searchQuery)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
