<div class="col-md-12">
    <h4 class="text-center">Today Transaction</h4>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Account</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Grams</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Cost Price</th>
                    <th scope="col">Selling Price</th>

                    {{-- <th scope="col">Total</th> --}}
                    <th scope="col">Gross Income</th>

                </tr>
            </thead>
           
            <tbody>
                @foreach ($SalesDetails as $key => $salesDetail)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $salesDetail->account }}</td>
                        <td>{{ $salesDetail->sales_productcode }}</td>
                        <td>{{ $salesDetail->productname }}</td>
                        <td>{{ $salesDetail->grams }}</td>
                        <td>{{ $salesDetail->qty }}</td>
                        <td>{{ number_format( $salesDetail->cost, 2  )}}</td>
                        <td>{{  number_format($salesDetail->price, 2) }}</td>

                        {{-- <td>{{ $salesDetail->total_cost }}</td> --}}
                        <td>{{  number_format($salesDetail->net_sale, 2)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">

        {{ $SalesDetails->appends(['filter_date' => $filterDate])->links('pagination::bootstrap-5') }}
    </div>
</div>
