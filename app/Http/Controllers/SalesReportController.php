<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\CustomerLayawayInfo;
use App\Models\expenses;
use App\Models\LayawayModel;
use App\Models\Product;
use App\Models\SalesDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalesReportController extends Controller
{
    protected $salesReport;
    public function __construct(){
        $this->salesReport = new SalesDetails();
    }

    public function index(Request $request){
              // Get today's date
              $today = Carbon::today();
    
              // Get the filter date from the request or default to today
              //$filterDate = $request->input('filter_date', $today);
          
           // Get filter dates from the request
    $dateFrom = $request->input('date_from', $today->copy()->startOfMonth()->toDateString());
    $dateTo = $request->input('date_to', $today->toDateString());

            // Ensure the dateTo includes the entire day
            $dateTo = Carbon::parse($dateTo)->endOfDay();
            // Query product history based on the date range
            //$SalesDetails = SalesDetails::whereBetween('created_at', [$dateFrom, $dateTo])->paginate(10);
              // Retrieve the necessary data filtered by the selected date
              $totalQuantity = Product::sum('quantity');
              $totalSalesQty = SalesDetails::whereBetween('created_at', [$dateFrom, $dateTo])->sum('qty');
              $totalSales = SalesDetails::whereBetween('created_at', [$dateFrom, $dateTo])->sum('total_cost');
              $totalCost = SalesDetails::whereBetween('created_at', [$dateFrom, $dateTo])->sum('cost');
              $totalExpenses = expenses::whereBetween('created_at', [$dateFrom, $dateTo])->sum('total_expenses');
              $totalProfit = SalesDetails::whereBetween('created_at', [$dateFrom, $dateTo])->sum('net_sale');
              $totalLayawawy = CustomerLayawayInfo::whereBetween('created_at', [$dateFrom, $dateTo])->count();
            
                      // Get sales details filtered by the selected date
                    //   $SalesDetails = SalesDetails::whereBetween('created_at', [$dateFrom, $dateTo])
                    //   ->paginate(10)
                    //   ->appends(['date_from' => $dateFrom, 'date_to' => $dateTo]);

                    $SalesDetails = $this->salesReport->whereBetween('created_at', [$dateFrom, $dateTo])->paginate(10);

                      // $SalesDetails = DB::table('productsales as ps')
                      // ->join('products as p', 'ps.productcode', '=', 'p.productcode')
                      // ->whereBetween('ps.created_at', [$dateFrom, $dateTo])
                      // ->select(
                      //     'ps.id as sales_id',
                      //       'ps.created_at',
                      //     'ps.productcode as sales_productcode',
                      //     'ps.account',
                      //     'p.productname',
                      //     'p.grams',
                      //     'ps.cost',
                      //     'ps.price',
                      //     'ps.qty',
                      //     'ps.total_cost',
                      //     'ps.net_sale'
                      // )
                      // ->orderBy('ps.created_at', 'asc')
                      // ->paginate(50);
                  

    // Return the view with all necessary data
    return view('product.salesreport', compact(
        'totalQuantity', 'totalSalesQty','totalSales', 'totalExpenses', 'totalProfit', 'SalesDetails', 
        'totalCost', 'dateFrom','dateTo','totalLayawawy'

    ));

    }
    public function export(Request $request)
{
    $dateFrom = $request->input('date_from');
    $dateTo = $request->input('date_to');

    // Ensure the dateTo includes the entire day
    $dateTo = \Carbon\Carbon::parse($dateTo)->endOfDay();

    return Excel::download(new SalesExport($dateFrom, $dateTo), 'sales_report.xlsx');
}

    
}
