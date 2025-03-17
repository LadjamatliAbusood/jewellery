<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
   public function index(){
    return view('sales.create');
   }
   public function search(Request $request){
    $query = $request->input('barcode');
    
    // Fetch products whose product code starts with the given query
    $products = Product::where('productcode', 'like', $query . '%')->get();

    return response()->json($products);
   }

   public function store(Request $request){
    try{
        DB::transaction(function() use($request){
            $sales = Sales::create([
                'total' => $request->total,
                'pay' => $request->pay,
                'balance' => $request->balance,
            ]);
            foreach($request->input('products') as $product){
                $Netsale = ($product['pro_price'] - $product['cost']) * $product['qty'];
                SalesDetails::create([
                    'sales_id' => $sales->id,
                    'account' => $request->UserAccount,
                    'productcode' => $product['barcode'],
                    'productname' => $product['pname'],
                    'cost' => $product['cost'],
                    'price' => $product['pro_price'],
                    'grams' => $product['grams'],
                    'qty' => $product['qty'],
                    'total_cost' => $product['total_cost'],
                    'net_sale' => $Netsale, 
                ]);

                $productRecord = Product::where('productcode', $product['barcode'])->first();
                if($productRecord){
                    $productRecord->decrement('quantity', $product['qty']);
                }
            }
        });
        return response()->json(['message' => 'Sales successfully added']);

    }catch(\Exception $e){
        return response()->json(['message' => 'Error adding sales'], 500);
    }
   }
   
}
