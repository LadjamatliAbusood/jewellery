@extends('layout.user')
@section('title', '3A Jewelery')
@section('contents')
    <div class="content">
        <div class="container">
            <h3 class="text-center mt-3">Point of Sales</h3>
            <div class="row">
                <!-- Left Side (Product Entry Form) -->
                <div class="col-12 col-md-8 mb-4">
                    <form id="frmInvoice">
                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="barcode">Product Code</label>
                                    <input type="text" class="form-control" placeholder="Product Code" id="barcode"
                                        name="barcode" size="25" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="pname">Product Name</label>
                                    <input type="text" class="form-control" placeholder="Product Name" id="pname"
                                        name="pname" size="25" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label for="pro_price">Price</label>
                                    <input type="text" class="form-control" placeholder="Price" id="pro_price"
                                        name="pro_price" size="25" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="qty">Quantity</label>
                                    <input type="number" class="form-control" placeholder="Qty" id="qty"
                                        name="qty" size="10" min="1" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="grams">Grams</label>
                                    <input type="text" class="form-control" placeholder="Grams" id="grams"
                                        name="grams" size="25" disabled>
                                </div>
                                <div class="col-md-4">

                                    <input type="text" class="form-control" placeholder="Total" id="total_cost"
                                        name="total_cost" size="20" hidden>
                                    <input type="text" class="form-control" placeholder="cost" id="cost"
                                        size="20" hidden>

                                    <label for="grams">&nbsp;</label>
                                    <button class="btn btn-success w-100" type="button" onclick="addproduct()">Add</button>

                                </div>


                            </div>

                        </div>
                    </form>

                    <!-- Product List -->
                    <div class="table-responsive">
                        <table class="table table-bordered" id="product_list">
                            <caption>Product</caption>
                            <thead>
                                <tr>
                                    <th style="width:40px">Remove</th>
                                    <th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Grams</th>
                                    <th style='display:none;'>Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right Side (Payment and Invoice Controls) -->
                <div class="col-12 col-md-4">
                    <form id="checkout-form">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Total" id="UserAccount"
                                name="UserAccount" value="{{ Auth::user()->name }}" hidden>

                            <label for="total" class="form-label">Total</label>

                            <input type="text" class="form-control" placeholder="Total" id="total" name="total"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="pay" class="form-label">Pay</label>
                            <input type="text" class="form-control" placeholder="Pay" id="pay" name="pay"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="balance" class="form-label">Balance</label>
                            <input type="text" class="form-control" placeholder="Balance" id="balance"
                                name="balance" readonly>
                        </div><br>
                        <div class="card" align="right">
                            <button type="button" id="save" class="btn btn-primary" onclick="addPurchase()">Update
                                Invoice</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
        <script>
            var isnew = true;
            var version_id = null;
            var current_stock = 0;
            var product_no = 0;
            getProductCode();
            getCategory();

            function getProductCode() {
                $("#barcode").empty();
                $("#barcode").keyup(function(e) {
                    var q = $("#barcode").val();
                    // Clear product fields if backspace is pressed and input is empty
                    if (e.key === "Backspace" && q === "") {
                        $("#pname").val('');
                        $("#grams").val('');
                        $("#pro_price").val('');
                        $("#total_cost").val('');
                        $("#cost").val('');
                    }

                    // If input is empty, no need to proceed with AJAX
                    if (q === '') {
                        return;
                    }

                    $.ajax({
                        type: "POST",
                        url: '{{ route('search') }}',
                        dataType: "JSON",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            barcode: $("#barcode").val(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.length > 0) {
                                // Loop through the results and find the first product code that exactly matches the input
                                var matchingProduct = data.find(product => product.productcode === q);

                                if (matchingProduct) {
                                    // If a matching product is found, complete the input and display product details
                                    $("#barcode").val(matchingProduct
                                        .productcode); // Auto-complete product code
                                    $("#pname").val(matchingProduct.productname); // Display product name
                                    $("#grams").val(matchingProduct.grams); //display grams
                                    $("#pro_price").val(matchingProduct.price); //display price
                                    $("#cost").val(matchingProduct.cost); // Display cost
                                    $("#qty").val(matchingProduct.quantity); // Display qty

                                    $("#qty").val(matchingProduct.quantity); // Display qty
                                    var price = Number($("#pro_price").val());
                                    var qty = Number($("#qty").val());
                                    var sum = price * qty;
                                    $("#total_cost").val(sum.toFixed(2)); // Calculate total cost


                                    // Store the current available stock quantity
                                    current_stock = matchingProduct.quantity;


                                    $("#pro_price").off("change").on("change", function() {
                                        var price = Number($(this).val());
                                        var qty = Number($("#qty").val());
                                        var sum = price * qty;
                                        $("#total_cost").val(sum.toFixed(2)); // Update total cost

                                        var originalCost = Number(matchingProduct.cost);
                                        if (price < originalCost) {
                                            Swal.fire({
                                                title: 'Error!',
                                                text: 'Price cannot be less than the cost!',
                                                icon: 'error',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                $(this).val(matchingProduct
                                                    .price); // Reset to original price
                                            });
                                        }
                                    });

                                    // Check if quantity is greater than available stock
                                    $("#qty").on("input", function() {
                                        var enteredQuantity = Number($("#qty").val());
                                        if (enteredQuantity > current_stock) {
                                            Swal.fire({
                                                title: 'Warning!',
                                                text: `Quantity entered is greater than available stock (${current_stock}).`,
                                                icon: 'warning',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                $("#qty").val(
                                                    ''
                                                ); // Reset to the maximum available stock
                                            });
                                        }
                                    });

                                }
                            } else {
                                // Optionally show a message if no product was found
                                $("#pname").val('No product found');
                                $("#pro_price").val('');
                                $("#grams").val('');
                                $("#cost").val('');
                            }
                        },
                        error: function(xhr, status, error) {

                        }
                    });
                });
            }
            $(function() {
                // Attach event listeners to both #pro_price and #qty
                $("#pro_price, #qty").on("input", function() {
                    var price = Number($("#pro_price").val()) || 0; // Default to 0 if empty
                    var qty = Number($("#qty").val()) || 0; // Default to 0 if empty
                    var sum = price * qty; // Calculate the total cost
                    $('#total_cost').val(sum.toFixed(2)); // Set value with 2 decimal places
                    console.log(sum);
                });
            });


            $(function() {
                $("#total, #pay").on("keydown keyup click", per);

                function per() {
                    var totalamount = (
                        Number($("#pay").val()) - Number($("#total").val())
                    );
                    $('#balance').val(totalamount);
                    console.log(totalamount);
                }

            });

            function getCategory() {
                $.ajax({
                    type: 'GET',
                    url: 'all_vendor.php',
                    dataType: 'JSON',
                    success: function(data) {
                        for (var i = 0; i < data.length; i++) {
                            $('#vendor').append($("<option/>", {
                                value: data[i].id,
                                text: data[i].vname,
                            }));
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(xhr, responseText);
                    }
                });
            }


            function addproduct() {
                var form = document.getElementById('frmInvoice');
                if (!form.checkValidity()) {
                    // If the form is not valid, stop further processing
                    form.reportValidity(); // This will show the validation message
                    return;
                }
                var product = {
                    barcode: $("#barcode").val(),
                    pname: $("#pname").val(),
                    pro_price: $("#pro_price").val(),
                    qty: $("#qty").val(),
                    grams: $("#grams").val(),
                    cost: $("#cost").val(),
                    total_cost: $("#total_cost").val(),
                    button: '<button type="button" class="btn btn-warning btn-xs"> <i class="bi bi-trash"></i></button>'

                };
                addRow(product);
                $('#frmInvoice')[0].reset();
                console.log("addproduct function triggered");
            }
            var total = 0;
            var discount = 0;
            var grosstotal = 0;
            var qtye = 0;
            var barcode = 0;
            var grams = 0;
            //
            function addRow(product) {
                console.log(product.total_cost);
                var $tableB = $('#product_list tbody');

                var $row = $(
                    "<tr><td><button type='button' name='record' class=' btn btn-warning btn-xs' onclick='deleteRow(this)'><i class='bi bi-trash'></i></td>" +
                    "<td>" + product.barcode + "</td><td class=\"price\">" + product.pname + "</td><td>" + product
                    .pro_price + "</td><td>" + product.qty + "</td><td>" + product.grams +
                    "</td><td style='display:none;'>" + product.total_cost + "</td><td  style='display:none;' >" + product
                    .cost + "</td>");
                $row.data("barcode", product.barcode);
                $row.data("pname", product.pname);
                $row.data("pro_price", product.pro_price);
                $row.data("qty", product.qty);
                $row.data("grams", product.grams);
                $row.data("total_cost", product.total_cost);
                $row.data("cost", product.cost);
                total += Number(product.total_cost);
                $('#total').val(total);
                console.log(product.total_cost);
                qtye += Number(product.qty);

                $row.find('deleterow').click(function(event) {
                    deleteRow($(event.currentTarget).parent('tr'));
                });
                $tableB.append($row);
            }

            function deleteRow(button) {
                var row = $(button).closest('tr');
                var rowTotalCost = Number(row.find('td:nth-child(7)').text()); // Assuming the total cost is in the 6th column

                // Subtract the row's total cost from the overall total
                total -= rowTotalCost;

                // Update the total input field
                $('#total').val(total);
                // Remove the row from the table
                row.remove();
            }

            function addPurchase() {

                console.log("addPurchase called");
                // Disable the button to prevent double clicks
                let btn = document.getElementById("save");
                btn.disabled = true;

                var table_data = [];
                $('#product_list tbody tr').each(function(row, tr) {
                    var sub = {
                        'barcode': $(tr).find('td:eq(1)').text(),
                        'pname': $(tr).find('td:eq(2)').text(),
                        'pro_price': $(tr).find('td:eq(3)').text(),
                        'qty': $(tr).find('td:eq(4)').text(),
                        'grams': $(tr).find('td:eq(5)').text(),
                        'total_cost': $(tr).find('td:eq(6)').text(),
                        'cost': $(tr).find('td:eq(7)').text(),
                    };
                    table_data.push(sub);
                });

                var total = $('#total').val();
                var pay = $('#pay').val();
                var balance = $('#balance').val();
                var UserAccount = $('#UserAccount').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('sales_add') }}',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        total: total,
                        pay: pay,
                        balance: balance,
                        UserAccount: UserAccount,
                        products: table_data,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.message === 'Sales successfully added') {
                            // Generate the receipt content dynamically
                            Swal.fire({
                                title: 'Success!',
                                text: 'Sales successfully added.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                // Optional: Do something after the user clicks 'OK'
                                if (result.isConfirmed) {
                                    // You can reload the page or do any further actions here
                                    location.reload(); // Example: Reload the page
                                }
                            });
                            // Now, submit the checkout form after the AJAX success
                            document.getElementById("checkout-form").submit(); // Submit the form
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while adding sales. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error("AJAX Error:", error);
                        btn.disabled = false;
                    }
                });
            }
        </script>
    @endpush
    @include('libraries.scripts')
@endsection


@push('css')
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        @media (max-width: 768px) {

            .table th,
            .table td {
                font-size: 0.9rem;
            }
        }
    </style>
@endpush
