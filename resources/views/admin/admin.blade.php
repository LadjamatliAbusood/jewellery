@include('libraries.style')
@include('libraries.scripts')
<title>@yield('title', '3A Jewelery')</title> <!-- Default Title if none is provided -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin/home') }}">3A Jewellery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('admin/home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/admin/product') }}">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/admin/pos') }}">Purchase</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('admin/expenses') }}">Expenses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('admin/layaway') }}">Lay away</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/admin/register') }}">Account</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/admin/modal-password') }}">Modal Password</a>

                </li>

            </ul>
            <ul class="navbar-nav">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                    alt="" class="rounded-circle" width="30" height="30">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">

                                <li><a class="dropdown-item" href="{{ url('/logout') }}">Sign out</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">Log in</a>
                        </li>
                        {{-- @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif --}}
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>
<div>
    @yield('content')
</div>
