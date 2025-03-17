@include('libraries.style')
@include('libraries.scripts')
<title>3A Jewelery</title>  
<!-- Sidebar -->

<body>
    <!-- Header -->
    <header class="px-4 py-2 shadow bg-dark">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Left side: Logo or title -->
            <div class="text-white">
                <h1 class="fw-bold fs-4 m-0">3A Jewellery</h1>
            </div>

            <!-- Right side: Navigation and profile -->
            <div class="d-flex align-items-center text-white">
                <!-- Horizontal navigation menu -->
                <ul class="nav me-4">
                    <li class="nav-item">
                        <a class="nav-link text-white px-3 py-2 rounded bg-transparent hover-bg-primary"
                            href="{{ url('/admin/register') }}">Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white px-3 py-2 rounded bg-transparent hover-bg-primary"
                            href="{{ route('admin/home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white px-3 py-2 rounded bg-transparent hover-bg-primary"
                            href="{{ route('logout') }}">Log out</a>
                    </li>
                </ul>

                <!-- Profile image and name -->
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-fill me-2"></i>
                    {{ Auth::user()->name }}
                </div>
            </div>
        </div>
    </header>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white flex-shrink-0 min-vh-100 ">
            <div class="text-center p-3">
                <a href="{{ url('/admin/supplier') }}"
                    class="d-flex align-items-center p-2 my-2 rounded text-white text-decoration-none hover-bg-primary">
                    <i class="bi bi-file-person-fill me-3"></i>
                    <span class="fw-bold">Supplier</span>
                </a>

                <a href="{{ route('goldtype') }}"
                class="d-flex align-items-center p-2 my-2 rounded text-white text-decoration-none hover-bg-primary">
                <i class="bi bi-receipt me-3"></i>
                <span class="fw-bold">Gold Type</span>
            </a>

            <a href="{{ route('gold-calculate') }}"
                class="d-flex align-items-center p-2 my-2 rounded text-white text-decoration-none hover-bg-primary">
                <i class="bi bi-calculator-fill me-3"></i>
                <span class="fw-bold">Inventory</span>
            </a>
                <a href="{{ url('/admin/product') }}"
                    class="d-flex align-items-center p-2 my-2 rounded text-white text-decoration-none hover-bg-primary">
                    <i class="bi bi-bag-plus-fill me-3"></i>
                    <span class="fw-bold">Product</span>
                </a>
                <a href="{{ route('history') }}"
                    class="d-flex align-items-center p-2 my-2 rounded text-white text-decoration-none hover-bg-primary">
                    <i class="bi bi-clock-history me-3"></i>
                    <span class="fw-bold">History</span>
                </a>
                <a href="{{ route('sales-report') }}"
                    class="d-flex align-items-center p-2 my-2 rounded text-white text-decoration-none hover-bg-primary">
                    <i class="bi bi-receipt me-3"></i>
                    <span class="fw-bold">Sales Report</span>
                </a>
            </div>
        </div>

        <!-- Main content -->
        <div>
            @yield('content')
        </div>
    </div>
</body>
