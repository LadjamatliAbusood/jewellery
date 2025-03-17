<?php

namespace App\Http\Controllers;

use App\Models\CustomerLayawayInfo;
use App\Models\expenses;
use App\Models\LayawayModel;
use App\Models\SalesDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
  public function index(Request $request){
     // Get today's date
     $today = Carbon::today();
    
     // Get the filter date from the request or default to today
     $filterDate = $request->input('filter_date', $today);

     $totalSalesQty = SalesDetails::whereDate('created_at', $filterDate)->sum('qty');
     $totalSales = SalesDetails::whereDate('created_at', $filterDate)->sum('total_cost');
     $totalExpenses = expenses::whereDate('created_at', $filterDate)->sum('total_expenses');
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
      ->paginate(10);
    return view('dashboard.cashier_transaction_table', compact('SalesDetails', 'filterDate','totalSalesQty','totalSales','totalExpenses','totalLayaway'));
  }
}
