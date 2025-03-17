@extends('admin.admin')

<body style="background-color:#f8f9fa;">
    @section('content')
        @include('libraries.scripts')

        <div class="content" style="padding: 5px;">
            <div class="container">
                <h3 align="center" class="mt-1">Gold Type, Cost and Price</h3>


           
                <div class="row">
                    <!-- Form Column -->

                    <div class="col-md-6">
                        <div class="form-area">
     
                                <form method="POST"
                                action="{{ isset($editingGold) ? route('gold.update', $editingGold->id) : route('gold.store') }}">
                                @csrf
                                @if (isset($editingGold))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <!-- Column 1 -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label>Gold Type</label>
                                            <input type="text" class="form-control" name="gold_type"
                                                value="{{ old('gold_type', $editingGold->gold_type ?? '') }}"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Cost per grams</label>
                                            <input type="text" class="form-control" name="gold_cost"
                                                 value="{{ old('gold_cost', $editingGold->gold_cost ?? '') }}"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Price per grams</label>
                                            <input type="text" class="form-control" name="gold_price"
                                              value="{{ old('gold_price', $editingGold->gold_price ?? '') }}"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="1"
                                                    {{ isset($editingGold) && $editingGold->status == 1 ? 'selected' : '' }}
                                                    >
                                                    Active
                                                </option>
                                                <option value="2"
                                                    {{ isset($editingGold) && $editingGold->status == 2 ? 'selected' : '' }}
                                                    >
                                                    Deactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    {{ isset($editingGold) ? 'Update' : 'Register' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Table Column -->
                    <div class="col-md-6">
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Gold Type</th>
                                    <th>Cost Per Gram</th>
                                    <th>Price Per Gram</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    @foreach ($Gold as $key => $gold)
                                        <tr>
                                            <td scope="col">{{ ++$key }}</td>
                                            <td scope="col">{{ $gold->gold_type }}</td>
                                          
                                            <td scope="col">{{  number_format($gold->gold_cost) }}</td>
                                            <td scope="col">{{  number_format($gold->gold_price )}}</td>
                                           
                                       
                                            <td scope="col">{{ $gold->status == 1 ? 'Active' : 'Deactive'}}</td>
                                       
                                            <td scope="col">
                                                <a href="{{ route('gold.edit', $gold->id) }}">
                                                 
                                                    <button class="btn btn-primary btn">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                </a>
                                             
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
</body>
