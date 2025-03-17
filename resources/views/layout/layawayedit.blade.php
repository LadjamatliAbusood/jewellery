@extends('layout.user')
@section('title', '3A Jewelry')
@section('contents')
    @include('libraries.scripts')
    <div class="content">
        <div class="container">

            <div class="row">
                <!-- Form Column -->
                <div class="col-md-12">
                    <div class="form-area">

                        <!-- First Form: Default View -->
                        <form id="defaultForm" action="{{ route('cashier.updatePayment', $layaway->id) }}" method="POST">
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
                                    <select name="status" class="form-control" readonly>
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
                                    <select name="plan" class="form-control" readonly>
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
                                <textarea class="form-control" readonly name="description" cols="2" rows="2">{{ $layaway->layaway_info }}</textarea>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        @if (optional($layaway->storage)->status != 3 && optional($layaway->storage)->status != 4)
                                            <input type="submit" class="btn btn-success w-100" value="Add Payment">
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Edit Lay Away Button
                                                                                                                                                                            id="editLayawayBtn"
                                                                                                                                                                            -->
                                        @if (optional($layaway->storage)->status != 3 && optional($layaway->storage)->status != 4)
                                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                                data-bs-target="#codeModal">
                                                Edit Lay Away
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Second Form: Edit Layaway -->
                        <form id="editLayawayForm" action="{{ route('cashier.updateLayawayDetails', $layaway->id) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Selling Price Field -->
                                <div class="col-md-3">
                                    <label>Selling Price</label>
                                    <input type="text" class="form-control" name="sellingprice"
                                        value="{{ $layaway->sellingprice }}">
                                </div>

                                <!-- Down Payment Field -->
                                <div class="col-md-3">
                                    <label>Down Payment</label>
                                    <input type="text" class="form-control" name="downpayment"
                                        value="{{ number_format($layaway->downpayment) }}" readonly>
                                </div>

                                <!-- Description Field -->
                                <div class="col-md-5">
                                    <label>Description</label>
                                    <input type="text" class="form-control" name="description"
                                        value="{{ $layaway->layaway_info }}">
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 mt-3">
                                        <!-- Button for Updating Layaway -->
                                        <button type="submit" name="action" value="update_layaway"
                                            class="btn btn-primary w-100">
                                            Update Layaway
                                        </button>

                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <!-- Button for Updating Layaway -->
                                        <button type="button" id="cancelLayawayBtn" class="btn btn-danger w-100">
                                            Cancel
                                        </button>

                                    </div>

                                </div>
                            </div>
                        </form>


                        <!-- Modal -->
                        <div class="modal fade" id="codeModal" tabindex="-1" aria-labelledby="codeModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="codeModalLabel">Message the Admin for password</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="layawayCodeForm">
                                            <div class="mb-3">

                                                <label for="layawayCodeInput" class="form-label">Enter password</label>
                                                <input type="text" class="form-control" id="layawayCodeInput"
                                                    required>
                                                <div id="verificationError" class="text-danger d-none"></div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
@push('js')
    <script>
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




        //Modal

        document.addEventListener("DOMContentLoaded", function() {
            let modalElement = document.getElementById("codeModal");
            let codeModal = new bootstrap.Modal(modalElement);

            document.getElementById("layawayCodeForm").addEventListener("submit", function(event) {
                event.preventDefault();
                const errorDiv = document.getElementById("verificationError");
                let enteredCode = document.getElementById("layawayCodeInput").value;
                errorDiv.classList.add("d-none");

                fetch("/validate-layaway-code", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            layaway_code: enteredCode
                        }),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.valid) {
                            // Hide the modal properly
                            codeModal.hide();

                            // Remove any existing modal backdrop
                            let backdrop = document.querySelector(".modal-backdrop");
                            if (backdrop) {
                                backdrop.remove();
                            }

                            // Show the second form, hide the first form
                            document.getElementById("defaultForm").style.display = "none";
                            document.getElementById("editLayawayForm").style.display = "block";
                        } else {
                            errorDiv.textContent = "Invalid password. Please try again.";
                            errorDiv.classList.remove("d-none");
                            document.getElementById("layawayCodeInput").value =
                                ""; // Clear the input for retry
                        }
                    })
                    .catch((error) => console.error("Error:", error));
            });

            // Handle Cancel Button - Reset to First Form
            document.getElementById("cancelLayawayBtn").addEventListener("click", function() {
                document.getElementById("editLayawayForm").style.display = "none";
                document.getElementById("defaultForm").style.display = "block";

                // Reset input field for next time
                document.getElementById("layawayCodeInput").value = "";

                // Show the modal again when clicking Edit after Cancel
                codeModal.show();
            });


        });
    </script>
@endpush
