@extends('admin.admin')

<body style="background-color:#f8f9fa;">
    @section('content')
        @include('libraries.scripts')


            <div class="container-fluid text-center mt-2">
                <h3 class="text-center">Inventory <br>
                    {{ now('Asia/Manila')->format('F j, Y h:i A') }}</h3>

                <div class="content" id="main-content" style="padding:30px; text-align: center;">

                <div class="row mb-5">
             

                    <!-- Responsive Table -->
                    <div class="table-responsive" >
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Gold Type</th>
                                    
                                    <th scope="col">Cost Per Grams</th>
                                    <th scope="col">Price Per Grams</th>
                                    <th scope="col">Total Quantity</th>
                                    <th scope="col">Total Grams</th>
                                    <th scope="col">Total Cost</th>
                        
                                    <th scope="col">Selling Price</th>
                                    <th scope="col">Total Gross</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($GoldCalculate as $index => $row)
                                <tr>
                                    
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row->gold_type }}</td>
                                  
                                   
                                    <td >{{ number_format( $row->cost_per_gram )}}</td>
                                    <td>{{  number_format($row->price_per_gram )}}</td>
                                    <td>{{ $row->total_quantity }}</td>
                                    <td>{{ number_format($row->total_grams) }}</td>
                                    <td>{{ number_format($row->total_cost) }}</td>
                                 
                                    <td>{{ number_format($row->Total_Price) }}</td>
                                    <td>{{ number_format($row->total_grossIncome) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                  
                </div>
            </div>
        </div>
    </body>
@endsection
@push('css')

<style>
    .status-badge {
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
    display: inline-block;
    text-align: center;
    width: 80px;
}

table .active {
    background-color: #28a745; 
    color: white;
}

.deactive {
    background-color: #dc3545; /* Red */
    color: white;
}
    </style>
@endpush



