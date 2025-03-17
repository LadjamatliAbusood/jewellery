{{-- @extends('sidebar.app')

<body style="background-color:#f8f9fa;">
    @section('content')
        @include('libraries.scripts') --}}




@extends('layout.user')

<body style="background-color:#f8f9fa;">
    @section('contents')
        @include('libraries.scripts')

        <div class="content">

            <div class="container-fluid mt-2">
                <h3 align="center">Product<br>
                    {{ now('Asia/Manila')->format('F j, Y h:i A') }}
                </h3>
                <div class="row">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-12">





                        <!-- Search Input -->
                        <!-- Search Input -->
                        <div class="row mb-3 mt-5">
                            <!-- Search Input -->
                            <div class="col-md-6 ms-auto">
                                <input type="text" class="form-control" name="search" id="search"
                                    placeholder="Search...">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Product Code</th>
                                            <th scope="col">Supplier</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Gold Type</th>
                                            <th scope="col">Quantity</th>

                                            <th scope="col">Grams</th>

                                            <th scope="col">Price</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($searchview as $key => $sv)
                                            <tr>
                                                <td scope="col">{{ ++$key }}</td>
                                                <td scope="col">{{ $sv->productcode }}</td>
                                                <td scope="col">{{ $sv->supplier->supplier_fullname }}</td>
                                                <td scope="col">{{ $sv->productname }}</td>
                                                <td scope="col">{{ $sv->gold_type }}</td>
                                                <td scope="col">{{ $sv->quantity }}</td>

                                                <td scope="col">{{ $sv->grams }}</td>

                                                <td scope="col">{{ $sv->price }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{-- Uncomment this line if you have pagination enabled --}}

                                {{ $searchview->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection

        @push('js')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('search').addEventListener('input', function() {
                        const searchQuery = this.value;
                        const url = new URL(window.location.href);

                        url.searchParams.set('search', searchQuery);
                        window.location.href = url.href;
                    });
                });
            </script>
        @endpush
