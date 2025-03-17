<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '3A Jewellery')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
@include('libraries.style')
@include('libraries.scripts')

<body>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">3A Jewellery</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('home/search') }}">View</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-bs-toggle="modal"
                                data-bs-target="#ProductcodeModal">Product</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('transactions.index') }}">Transaction</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('home/expenses') }}">Expenses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('home/layaway') }}">Lay away</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/logout') }}">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Modal -->
        {{-- <div class="modal fade" id="verificationModal" tabindex="-1" aria-labelledby="verificationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verificationModalLabel">Enter Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="verificationForm">
                            <div class="mb-3">
                                <label for="passwordInput" class="form-label">Password</label>
                                <input type="password" class="form-control" id="passwordInput" required>
                            </div>
                            <div id="verificationError" class="text-danger d-none"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="verifyPasswordBtn" class="btn btn-primary">Verify</button>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="modal fade" id="ProductcodeModal" tabindex="-1" aria-labelledby="codeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="codeModalLabel">Message the Admin for password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="ProductForm">
                            <div class="mb-3">

                                <label for="ProductPassword" class="form-label">Enter password</label>
                                <input type="text" class="form-control" id="ProductPassword" required>
                                <div id="verificationErrorPassword" class="text-danger d-none"></div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <main class="container py-1">
            <div>@yield('contents')</div>
        </main>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('openVerificationModal').addEventListener('click', function () {
            const modal = new bootstrap.Modal(document.getElementById('verificationModal'));
            modal.show();
        });

        document.getElementById('verifyPasswordBtn').addEventListener('click', function () {
            const passwordInput = document.getElementById('passwordInput');
            const errorDiv = document.getElementById('verificationError');
            const correctPassword = '@3AJewellery'; // Replace with your desired password

            // Reset error message
            errorDiv.classList.add('d-none');

            if (passwordInput.value === correctPassword) {
                // Redirect to Product page if password is correct
                window.location.href = '{{ url("home/add-product") }}';
            } else {
                // Show error message for incorrect password
                errorDiv.textContent = 'Invalid password. Please try again.';
                errorDiv.classList.remove('d-none');
                passwordInput.value = ''; // Clear the input for retry
            }
        });
    </script> --}}


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let modalElement = document.getElementById("ProductcodeModal");
            let codeModal = new bootstrap.Modal(modalElement);

            document.getElementById("ProductForm").addEventListener("submit", function(event) {
                event.preventDefault();
                const errorDiv = document.getElementById("verificationErrorPassword");
                let enteredCode = document.getElementById("ProductPassword").value;
                errorDiv.classList.add("d-none");

                fetch("/product-password", {
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

                            // Redirect to add product page
                            window.location.href = '{{ url('home/add-product') }}';

                        } else {
                            errorDiv.textContent = "Invalid password. Please try again.";
                            errorDiv.classList.remove("d-none");
                            document.getElementById("ProductPassword").value =
                                ""; // Clear the input for retry
                        }
                    })
                    .catch((error) => console.error("Error:", error));
            });


        });
    </script>
</body>

</html>
