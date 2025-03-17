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
                                // $("#pro_cost").val(matchingProduct.cost); // Display cost

                                $("#pro_price").off("change").on("change", function() {
                                    var inputPrice = Number($(this).val());
                                    var originalCost = Number(matchingProduct.cost);
                                    var originalPrice = Number(matchingProduct.price);
                                    // Check if the input price is less than the cost
                                    if (inputPrice < originalCost) {
                                        alert("Price cannot be less than the cost!");
                                        $(this).val(
                                            originalPrice); // Reset to the original cost
                                    }
                                });
                            }
                        } else {
                            // Optionally show a message if no product was found
                            $("#pname").val('No product found');
                            $("#pro_price").val('');
                            $("#grams").val('');
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

        function addRow(product) {
            console.log(product.total_cost);
            var $tableB = $('#product_list tbody');
            var $row = $(
                "<tr><td><button type='button' name='record' class=' btn btn-warning btn-xs' onclick='deleteRow(this)'><i class='bi bi-trash'></i></td>" +
                "<td>" + product.barcode + "</td><td class=\"price\">" + product.pname + "</td><td>" + product
                .pro_price + "</td><td>" + product.qty + "</td><td>" + product.grams +
                "</td><td>" + product.total_cost + "</td>");
            $row.data("barcode", product.barcode);
            $row.data("pname", product.pname);
            $row.data("pro_price", product.pro_price);
            $row.data("qty", product.qty);
            $row.data("grams", product.grams);
            $row.data("total_cost", product.total_cost);
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
            var table_data = [];
            $('#product_list tbody tr').each(function(row, tr) {
                var sub = {
                    'barcode': $(tr).find('td:eq(1)').text(),
                    'pname': $(tr).find('td:eq(2)').text(),
                    'pro_price': $(tr).find('td:eq(3)').text(),
                    'qty': $(tr).find('td:eq(4)').text(),
                    'grams': $(tr).find('td:eq(5)').text(),
                    'total_cost': $(tr).find('td:eq(6)').text(),
                };
                table_data.push(sub);
            });
            console.log(table_data);

            var total = $('#total').val();
            var pay = $('#pay').val();
            var balance = $('#balance').val();

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
                    products: table_data,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data);
                    if (data.status == 'success') {
                        alert('Sales added successfully');
                        location.reload();
                    }
                }
            })
        }
    </script>
@endpush
@stack('js')
