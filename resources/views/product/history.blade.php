@extends('sidebar.app')

<body style="background-color:#f8f9fa;">
    @section('content')
        @include('libraries.scripts')

        <div class="content" id="main-content" style="padding: 20px">
            <div class="container-fluid text-center">
                <h3 class="text-center">History</h3>



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
                    <form method="GET" action="{{ route('export.product.history') }}"
                        class="d-flex align-items-center ms-3">
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
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Product Code</th>
                                    <th>Supplier</th>
                                    <th>Product Name</th>
                                    <th>Gold Type</th>
                                    <th>Quantity</th>
                                    <th>Cost Per Gram</th>
                                    <th>Price Per Gram</th>
                                    <th>Grams</th>
                                    <th>Cost Price</th>
                                    <th>Selling Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productHistory as $key => $phi)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ \Carbon\Carbon::parse($phi->created_at)->format('F d, Y h:i A') }}</td>
                                    
                                        <td>{{ $phi->productcode }}</td>
                                        <td>{{ $phi->supplier->supplier_fullname }}</td>
                                        <td>{{ $phi->productname }}</td>
                                        <td>{{ $phi->gold_type }}</td>
                                        <td>{{ $phi->quantity }}</td>
                                        <td>{{ number_format( $phi->cost_per_gram) }}</td>
                                        <td>{{  number_format($phi->price_per_gram)}}</td>
                                        <td>{{ $phi->grams }}</td>
                                        <td>{{  number_format($phi->cost) }}</td>
                                        <td>{{ number_format( $phi->price)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    {{-- <div class="d-flex justify-content-center">

                        {{ $productHistory->appends(['date_from' => $dateFrom, 'date_to' => $dateTo])->links('pagination::bootstrap-5') }}
                    </div> --}}
                </div>
            </div>
        </div>
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
                    const productCode = row.querySelector('td:nth-child(3)').textContent
                        .toLowerCase();
                    const productName = row.querySelector('td:nth-child(5)').textContent
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
