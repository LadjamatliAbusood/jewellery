@extends('admin.admin')

<body style="background-color:#f8f9fa;">
    @section('content')
        @include('libraries.scripts')
        <div class="content">
            <div class="container">

                <div class="row">
                    <!-- Form Column -->
                    <div class="col-md-12">
                        <div class="form-area">
                            <form action="{{ route('admin.updatePayment', $layaway->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <h3 align="center"> Customer Information</h3>
                                <div class="row">
                                    <div class="col-md-1">
                                        <label>Number</label>
                                        <input type="number" class="form-control" name="customer_number"
                                            value="{{ $layaway->customer_number }}" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Customer Name</label>
                                        <input type="text" class="form-control" name="fullname"
                                            value="{{ $layaway->fullname }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" name="customer_cn"
                                            value="{{ $layaway->customer_cn }}" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Lay Away Information</label>
                                        <input type="text" class="form-control" name="layaway_info"
                                            value="{{ $layaway->layaway_info }}" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control" @readonly(true)>
                                            <option value="1">
                                                @if (optional($layaway->storage)->status == 1)
                                                    New
                                                @elseif(optional($layaway->storage)->status == 2)
                                                    Ongoing
                                                @elseif(optional($layaway->storage)->status == 3)
                                                    Fully Paid
                                                @elseif(optional($layaway->storage)->status == 4)
                                                    Canceled
                                                @else
                                                    Unknown Status
                                                @endif
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Selling Price</label>
                                        <input type="text" class="form-control" name="sellingprice"
                                            value="{{ number_format($layaway->sellingprice) }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Down Payment</label>
                                        <input type="text" class="form-control" name="downpayment"
                                            value="{{ number_format($layaway->downpayment) }}" readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Lay Away Plan</label>
                                        <select name="plan" class="form-control" @readonly(true)>
                                            <option value="1">
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
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Amount</label>
                                        <input type="text" class="form-control" name="amount">
                                    </div>

                                    <label class="form-label text-dark">Description</label>
                                    <textarea class="form-control" name="description" cols="2" rows="2" readonly> {{ $layaway->layaway_info }}</textarea>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            @if (optional($layaway->storage)->status != 3 && optional($layaway->storage)->status != 4)
                                                <input type="submit" class="btn btn-warning w-100" value="Add Payment">
                                            @endif
                                        </div>
                                        @if (optional($layaway->storage)->status != 3 && optional($layaway->storage)->status != 4)
                                            <button type="button" id="editLayawayBtn" class="btn btn-success w-100"
                                                data-bs-toggle="modal" data-bs-target="#codeModal">
                                                Edit Lay Away
                                            </button>
                                        @endif
                                    </div>
                            </form>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <form action="{{ route('cancelLayaway', $layaway->id) }}" method="POST"
                                        class="cancel-form">
                                        @csrf
                                        @method('PUT')
                                        @if (optional($layaway->storage)->status != 3)
                                            <input type="submit" class="btn btn-danger w-100" value="Cancel Layaway">
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <!-- Payment History Table -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Remaining Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($CustomerPayment as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('F d, Y') }}</td>
                                <td>{{ number_format($payment->amount) }}</td>
                                <td>{{ number_format($payment->balance) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="codeModal" tabindex="-1" aria-labelledby="codeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="codeModalLabel">Enter Layaway Codezxc</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="layawayCodeForm">
                                <div class="mb-3">
                                    <label for="layawayCodeInput" class="form-label">Enter Codezxc</label>
                                    <input type="text" class="form-control" id="layawayCodeInput" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Code</button>
                            </form>
                        </div>
                    </div>
                </div>
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

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cancelForm = document.querySelector('.cancel-form');
                cancelForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent form submission

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Do you really want to cancel this layaway?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, cancel it!',
                        cancelButtonText: 'No, keep it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, submit the form
                            cancelForm.submit();
                        }
                    });
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                const sellingPriceInput = document.querySelector("input[name='sellingprice']");
                const downPaymentInput = document.querySelector("input[name='downpayment']");
                const amountInput = document.querySelector("input[name='amount']");
                const form = document.querySelector("form");

                function validateAmount() {
                    const sellingPrice = parseFloat(sellingPriceInput.value.replace(/,/g, "")) || 0;
                    const downPayment = parseFloat(downPaymentInput.value.replace(/,/g, "")) || 0;
                    const amount = parseFloat(amountInput.value) || 0;
                    const totalPayment = downPayment + amount;

                    if (totalPayment > sellingPrice) {
                        amountInput.setCustomValidity("Total payment cannot exceed the selling price!");
                    } else {
                        amountInput.setCustomValidity("");
                    }
                }

                // Check validation on input change
                amountInput.addEventListener("input", validateAmount);

                // Prevent form submission if validation fails
                form.addEventListener("submit", function(event) {
                    validateAmount();
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        alert("Error: Total payment (Down Payment + Amount) cannot exceed Selling Price!");
                    }
                });
            });
        </script>


        {{--  modal code --}}


        {{-- <script>
            $(document).ready(function() {
                $("#layawayCodeForm").submit(function(event) {
                    event.preventDefault();

                    var enteredCode = $("#layawayCodeInput").val();

                    $.ajax({
                        url: "/validate-layaway-code",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            layaway_code: enteredCode
                        },
                        success: function(response) {
                            if (response.valid) {
                                alert("Code Accepted!");
                                $("#codeModal").modal("hide"); // Close modal
                                location.reload(); // Reload page or redirect as needed
                            } else {
                                alert("Invali   d or Expired Code!");
                            }
                        }
                    });
                });
            });
        </script> --}}
    @endpush
