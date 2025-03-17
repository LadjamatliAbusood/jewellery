@extends('admin.admin')

<body style="background-color:#f8f9fa;">
    @section('content')
        @include('libraries.scripts')
        <div class="container">
            {{-- <h3 align="center">Today Lay Away<br>
                {{ now('Asia/Manila')->format('F j, Y h:i A') }}</h3> --}}


            <div class="row">
                <!-- Form Column -->
                <div class="col-md-12">
                    <div class="form-area">





                        <form method="POST" action="{{ route('admin.layaway.store') }}">
                            @csrf

                            <h3 align="center">Lay away Customer Information</h3>
                            @csrf
                            <div class="row">
                                <input type="hidden" name="account" value="{{ Auth::user()->name }}">
                                <div class="col-md-2">
                                    <label>Number</label>
                                    <input type="number" class="form-control" name="customer_number">
                                </div>

                                <div class="col-md-6">
                                    <label>Customer Name</label>
                                    <input type="text" class="form-control" name="fullname">
                                </div>
                                <div class="col-md-4">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control" name="customer_cn">
                                </div>

                                <div class="col-md-3">
                                    <label>Lay Away Information</label>
                                    <input type="text" class="form-control" name="layaway_info">
                                </div>
                                <div class="col-md-3">
                                    <label>Selling Price</label>
                                    <input type="text" class="form-control" name="sellingprice">
                                </div>
                                <div class="col-md-3">
                                    <label>Down Payment</label>
                                    <input type="text" class="form-control" name="downpayment">
                                </div>
                                <div class="col-md-3">
                                    <label>Lay Away Plan</label>
                                    <select name="plan" id="plan" class="form-control">
                                        <option value="1">
                                            15 Days
                                        </option>
                                        <option value="2">
                                            3 Months
                                        </option>
                                        <option value="3">
                                            4 Months
                                        </option>
                                        <option value="4">
                                            5-6 Months
                                        </option>

                                    </select>
                                </div>

                                <label class="form-label text-dark">Description</label>
                                <textarea class="form-control" name="description" cols="2" rows="2" required placeholder="Others..."></textarea>
                                <div class="row">

                                    <div class="col-md-5 mt-3">

                                        <input type="submit" class="btn btn-success" value="Register Plan">
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
                <div class="col-md-6 ms-auto mt-4">




                    <input type="text" class="form-control" name="search" id="search" placeholder="Search...">


                </div>


                <!-- Table Column -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-hover float-end">

                        {{--                
                        <table class="table table-bordered mt-2"> --}}
                        <thead>
                            <tr>
                                <th>Date Lay Away</th>
                                <th>Number</th>
                                <th>Full name</th>
                                <th>Lay Away Information</th>
                                <th>Selling Price</th>
                                <th>Downpayment</th>
                                <th>Balance</th>
                                <th>Status</th>
                                <th>View</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Customerlayawayinfo as $layaway)
                                <tr>
                                    <td>{{ $layaway->created_at->format('F d, Y ') }}</td>

                                    <td>{{ $layaway->customer_number }}</td>
                                    <td>{{ $layaway->fullname }}</td>
                                    <td>{{ $layaway->layaway_info }} ,

                                        @if ($layaway->plan == 1)
                                            15 Days
                                        @elseif($layaway->plan == 2)
                                            3 Months
                                        @elseif($layaway->plan == 3)
                                            4 Months
                                        @elseif($layaway->plan == 4)
                                            5 - 6 Months
                                        @else
                                            Unknown Plan
                                        @endif
                                    </td>
                                    <td>{{ number_format($layaway->sellingprice) }}</td>
                                    <td>{{ number_format($layaway->downpayment) }}</td>
                                    <td>
                                        {{ number_format(optional($layaway->storage)->balance ?? 0) }}
                                    </td>
                                    <td>
                                        @if (optional($layaway->storage)->status == 1)
                                            <span class="badge bg-success">New</span>
                                        @elseif(optional($layaway->storage)->status == 2)
                                            <span class="badge bg-primary">Ongoing</span>
                                        @elseif(optional($layaway->storage)->status == 3)
                                            <span class="badge bg-warning">Fully Paid</span>
                                        @elseif(optional($layaway->storage)->status == 4)
                                            <span class="badge bg-danger">Canceled</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown status</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.layawayeditadmin', $layaway->id) }}">View</a>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

            .thead-dark {
                background-color: #343a40;
                color: #fff;
            }

            ul {
                list-style: none;
            }
        </style>
    @endpush
    @push('js')
    </body>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sellingPriceInput = document.querySelector("input[name='sellingprice']");
            const downPaymentInput = document.querySelector("input[name='downpayment']");
            const form = document.querySelector("form");

            function validateDownPayment() {
                const sellingPrice = parseFloat(sellingPriceInput.value) || 0;
                const downPayment = parseFloat(downPaymentInput.value) || 0;

                if (downPayment > sellingPrice) {
                    downPaymentInput.setCustomValidity("Down Payment cannot be greater than Selling Price!");
                } else {
                    downPaymentInput.setCustomValidity("");
                }
            }

            // Check validation on input change
            downPaymentInput.addEventListener("input", validateDownPayment);
            sellingPriceInput.addEventListener("input", validateDownPayment);

            // Prevent form submission if validation fails
            form.addEventListener("submit", function(event) {
                validateDownPayment();
                if (!form.checkValidity()) {
                    event.preventDefault();
                    alert("Error: Down Payment cannot be greater than Selling Price!");
                }
            });
        });

        //search function
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('search').addEventListener('input', function() {
                const searchQuery = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const customernumber = row.querySelector('td:nth-child(2)').textContent
                        .toLowerCase();
                    const fullname = row.querySelector('td:nth-child(3)').textContent
                        .toLowerCase();

                    if (fullname.includes(searchQuery) || customernumber.includes(searchQuery)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush()
