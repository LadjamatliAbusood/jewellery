@extends('layout.user')
@section('title', '3A Jewelery')
@section('contents')
    @include('libraries.scripts')
    <div class="content">
        <div class="container">
            <h3 align="center">Today Expenses<br>
                {{ now('Asia/Manila')->format('F j, Y h:i A') }}</h3>

            <div class="row">

                <!-- Form Column -->
                <div class="col-md-12">
                    <div class="form-area">
                        <form method="POST" action="  {{ route('cashier.expenses.store') }}">
                            <input type="text" name="account" class="form-control" value="{{ Auth::user()->name }}" hidden>
                            @csrf

                            <div class="col-mb-4">
                                <label class="form-label text-dark">Description</label>

                                <textarea class="form-control" name="description" id="" cols="2" rows="3" required></textarea>

                            </div>

                            <div class="col-mb-4">
                                <label class="form-label text-dark">Total Expenses</label>
                                <input type="number" name="total_expenses" id="total_expenses" class="form-control"
                                    placeholder="Total Expenses" required>
                            </div>


                            <br>
                            <button type="submit" class="btn btn-success">
                                Add Expenses
                            </button>
                        </form>
                    </div>
                </div>


                <!-- Table Column -->
               
                    <div class="d-flex justify-content-end">
                        <form method="GET" action="{{ route('cashier.expenses.index') }}">
                            <div class="text-end">
                                <label for="datePicker" class="form-label d-block">Select Date:</label>
                                <div class="d-flex">
                                    <input type="date" id="datePicker" name="filter_date" class="form-control w-auto"
                                        value="{{ request('filter_date') }}">
                                    <button type="submit" class="btn btn-primary ms-2">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-bordered mt-2">
                    <thead >
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Description</th>
                                <th>Total Expenses</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($expenses as $key => $expense)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{\Carbon\Carbon::parse($expense->created_at)->format('M d, Y') }}</td>
                                    <td>{{ $expense->account }}</td>
                                    <td>{{ $expense->description }}</td>
                                    <td>{{ $expense->total_expenses }}</td>

                                    {{-- <a href="" class="btn btn-primary btn-sm">Edit</a> --}}
                                    {{-- {{ route('supplier.edit', $user->id) }} --}}

                                    {{-- <form action="{{ route('register.destroy', $user->id) }} " method="POST"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form> --}}

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{-- Uncomment this line if you have pagination enabled --}}
                    {{ $expenses->links('pagination::bootstrap-5') }}
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
