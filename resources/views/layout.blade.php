<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @include('libraries.style')

    <title>3A Jewellery</title>
</head>

<body class="bg-light">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12 bg-dark">
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
            </div>


            <div>
                @yield('content')
            </div>

        </div>

    </div>

    @include('libraries.scripts')
</body>

</html>
