@extends('layout')
@section('content')
    <div class="container">
        <h3 align="center" class="mt-1">Supplier Information Edit</h3>
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-8">
                <div class="form-area">
                    <form method="POST" action="{{ route('supplier.update', $supplier->id) }}">
                        {!! csrf_field() !!}
                        @method('PATCH')
                        <div class="row">
                            <div class="col-md-6">
                                <label>Supplier Information</label>
                                <input type="text" class="form-control" name="supplier_fullname"
                                    value="{{ $supplier->supplier_fullname }}">
                            </div>
                            <div class="col-md-6">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option selected disabled>Select Status</option>
                                    <option value="1" {{ $supplier->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ $supplier->status == 2 ? 'selected' : '' }}>Deactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <input type="submit" class="btn btn-primary" value="Update">
                            </div>
                        </div>
                    </form>
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
    </style>
@endpush
