@extends('sidebar.app')


<body style="background-color:#f8f9fa;">
    @section('content')
        @include('libraries.scripts')

        <div class="content" style=" padding: 20px;">
            <div class="container">
                <h3 align="center" class="mt-1">Supplier Information</h3>

                <div class="row">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-12">
                        <div class="form-area">
                            <form method="POST"
                                action="{{ isset($editingSupplier) ? route('supplier.update', $editingSupplier->id) : route('supplier.store') }}">
                                @csrf
                                @if (isset($editingSupplier))
                                    @method('PUT')
                                @endif

                                <div class="mb-3">
                                    <label>Supplier Full Name</label>
                                    <input type="text" class="form-control" name="supplier_fullname"
                                        value="{{ old('supplier_fullname', $editingSupplier->supplier_fullname ?? '') }}"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1"
                                            {{ isset($editingSupplier) && $editingSupplier->status == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="2"
                                            {{ isset($editingSupplier) && $editingSupplier->status == 2 ? 'selected' : '' }}>
                                            Deactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    {{ isset($editingSupplier) ? 'Update' : 'Register' }}
                                </button>
                            </form>
                        </div>

                        <table class="table mt-5">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Supplier Full Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Suppliers as $key => $supplier)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $supplier->supplier_fullname }}</td>
                                        <td>{{ $supplier->status == 1 ? 'Active' : 'Deactive' }}</td>
                                        <td>
                                            <a href="{{ route('supplier.edit', $supplier->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            {{-- <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST"
                                            style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form> --}}
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
