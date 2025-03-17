@extends('admin.admin')
@section('content')
    @include('libraries.scripts')

    <div class="content" style="padding: 20px;">
        <div class="container">
            <h3 align="center" class="mt-1">Create Account</h3>

            <div class="row">

                <!-- Form Column -->
                <div class="col-md-6">
                    <div class="form-area">
                        <form method="POST" action="{{ route('register.save') }}">
                            @csrf

                            <div class="col-mb-4">
                                <label class="form-label text-dark">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="name"
                                    required>
                            </div>

                            <div class="col-mb-4">
                                <label class="form-label text-dark">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="email@gmail.com" required>
                            </div>

                            <div class="col-mb-4">
                                <label class="form-label text-dark">Password</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="••••••••" required>
                            </div>


                            <div class="col-mb-4">
                                <label class="form-label text-dark">Type</label>
                                <select name="type" class="form-control" required>
                                    <option value="0">Cashier</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Manager</option> <!-- Make sure this is included -->
                                </select>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Table Column -->
                <div class="col-md-6">
                    <table class="table mt-2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->type }}</td>
                                    <td></td>
                                    <td>
                                        {{-- <a href="" class="btn btn-primary btn-sm">Edit</a> --}}
                                        {{-- {{ route('supplier.edit', $user->id) }} --}}

                                        {{-- <form action="{{ route('register.destroy', $user->id) }} " method="POST"
                                            style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form> --}}

                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('user.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="confirmDelete({{ $user->id }})">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
