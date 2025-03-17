<?php

namespace App\Http\Controllers;

use App\Models\CustomerLayawayInfo;
use App\Models\expenses;
use App\Models\LayawayModel;
use App\Models\Product;
use App\Models\SalesDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        
        return view('home');
    }

    public function adminHome(Request $request)
    {
        // Get today's date
        $today = Carbon::today();
    
        // Get the filter date from the request or default to today
        $filterDate = $request->input('filter_date', $today);
    
        // Retrieve the necessary data filtered by the selected date
        $totalQuantity = Product::sum('quantity');
        $totalSalesQty = SalesDetails::whereDate('created_at', $filterDate)->sum('qty');
        $totalSales = SalesDetails::whereDate('created_at', $filterDate)->sum('total_cost');
        $totalCost = SalesDetails::whereDate('created_at', $filterDate)->sum('cost');
        $totalExpenses = expenses::whereDate('created_at', $filterDate)->sum('total_expenses');
        $totalProfit = SalesDetails::whereDate('created_at', $filterDate)->sum('net_sale');
        $totalLayaway = CustomerLayawayInfo::whereDate('created_at',$filterDate)->count();
        // Get sales details filtered by the selected date
        $SalesDetails = DB::table('productsales as ps')
            ->join('products as p', 'ps.productcode', '=', 'p.productcode')
            ->whereDate('ps.created_at', $filterDate)
            ->select(
                'ps.id as sales_id',
                'ps.productcode as sales_productcode',
                'ps.account',
                'p.productname',
                'p.grams',
                'ps.cost',
                'ps.price',
                'ps.qty',
                'ps.total_cost',
                'ps.net_sale'
            )
            ->paginate(250);
    
        // Return the view with all necessary data
        return view('dashboard', compact(
            'totalQuantity', 'totalSalesQty','totalSales', 'totalExpenses', 'totalProfit', 'SalesDetails', 'filterDate',
            'totalCost','totalLayaway'
        ));
    }
    
}
