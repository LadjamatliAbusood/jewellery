<?php

namespace App\Http\Controllers;

use App\Models\ProductHistory;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductHistoryController extends Controller
{
    protected $productHistory;
    public function __construct(){
        $this->productHistory = new ProductHistory();
    }

    public function index(Request $request)
    { 
         // Default to today's date if no date is selected
    $today = Carbon::today();

    // Get filter dates from the request
    $dateFrom = $request->input('date_from', $today->copy()->startOfMonth()->toDateString());
    $dateTo = $request->input('date_to', $today->toDateString());

     // Ensure the dateTo includes the entire day
     $dateTo = Carbon::parse($dateTo)->endOfDay();
    // Query product history based on the date range
    $productHistory = ProductHistory::whereBetween('created_at', [$dateFrom, $dateTo])->get();

    // Fetch suppliers (if needed)
    $suppliers = Supplier::where('status', 1)->pluck('supplier_fullname', 'id');

    return view('product.history', compact('productHistory', 'suppliers', 'dateFrom', 'dateTo'));
    }

}
