@include('libraries.style')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>3A Jewelery</title>
</head>

<body>
    <section class="bg-light">
        <div class="d-flex flex-column align-items-center justify-content-center px-3 py-5 mx-auto vh-100">
            <div class="text-center mb-4">
                <h2 class="fw-semibold text-dark">Login</h2>
            </div>
            <div class="card shadow border-0 w-100 mx-auto" style="max-width: 24rem;">
                <div class="card-body p-4">
                    <h3 class="h5 fw-bold text-dark mb-3">Sign in to your account</h3>
                    <form method="post" action="{{ route('login.action') }}">

                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <strong>Error!</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark">Your email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="name@company.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-dark">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="••••••••" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label text-muted" for="remember">Remember me</label>
                            </div>
                            <a href="#" class="text-primary text-decoration-underline"></a>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
@push('js')
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
@endpush
