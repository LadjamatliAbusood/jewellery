 {{--
 @include('libraries.style')
<section class="bg-light">
    <div class="d-flex flex-column align-items-center justify-content-center px-3 py-5 mx-auto vh-100">
        <div class="mb-4 text-center">
            <h2 class="fw-semibold text-dark">Register</h2>
        </div>
        <div class="card shadow border-0 w-100 mx-auto" style="max-width: 24rem;">
            <div class="card-body p-4">
                <h3 class="h5 fw-bold text-dark mb-3">Create an account</h3>
                <form method="POST" action="">
                    {{ route('register.save') }} 
                     @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label text-dark">Your name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="name"
                            required>
                        @error('name')
    <span class="text-danger">{{ $message }}</span>
@enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-dark">Your email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="name@company.com" required>
                        @error('email')
    <span class="text-danger">{{ $message }}</span>
@enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-dark">Password</label>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="••••••••" required>
                        @error('password')
    <span class="text-danger">{{ $message }}</span>
@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Create an account</button>
                </form>
            </div>
        </div>
    </div>
</section>
