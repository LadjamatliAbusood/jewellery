<?php

namespace App\Http\Controllers;

use App\Models\GoldModel;
use App\Models\Layawaycode;
use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\Supplier;
use Illuminate\Http\Request;

class CashierAddProductController extends Controller
{
    protected $product;
    public function __construct(){
        $this->product = new Product();
    }

   public function index(Request $request)
   {
       
  

      $query = $request->input('search');
      $products = $this->product
          ->when($query, function ($queryBuilder, $search) {
              return $queryBuilder->where('productname', 'LIKE', "%$search%")
                  ->orWhere('productcode', 'LIKE', "%$search%")
                  ->orWhereHas('supplier', function ($query) use ($search) {
                      $query->where('supplier_fullname', 'LIKE', "%$search%");
                  });
          })
          ->orderBy('created_at', 'DESC')
          ->paginate(250);
         

      $allProductCodes = Product::pluck('productcode');
      $goldtype = Product::pluck('gold_type');

      $suppliers = Supplier::where('status',1)->pluck('supplier_fullname', 'id');
      $gold = GoldModel::where('status', 1)->get(['id', 'gold_type', 'gold_cost','gold_price']);
    

      return view('layout.addproduct',compact('products','suppliers','allProductCodes','goldtype','gold'));

     
 
   }
   public function store(Request $request)
   {
       $validated = $request->validate([
           'gold_id' => 'required|exists:gold,id',
           'supplier_id' => 'required|exists:suppliers,id',
           'productcode' => 'required|string|max:255',
           'productname' => 'required|string|max:255',
           'quantity' => 'required|numeric',
           'cost_per_gram' => 'required|numeric',
           'price_per_gram' => 'required|numeric',
           'grams' => 'required|numeric',
           'cost' => 'required|numeric',
           'price' => 'required|numeric',
       ]);
       $gold = GoldModel::find($validated['gold_id']);
       $validated['gold_type'] = $gold->gold_type;

       $product = Product::create($validated);
       ProductHistory::create(array_merge($validated, ['product_id' => $product->id]));
       return redirect()->back()->with('success', 'Product successfully Added');
   }


   public function verifyPassword(Request $request)
{
    $code = $request->input('layaway_code');
    $layawaycode = Layawaycode::where('layaway_code', $code)->first();

    if(!$layawaycode){
        return response()->json(['valid' => false, 'message' => 'Invalid layaway code.'], 400);
    }
    if($layawaycode->Iseen == 1){
        return response()->json(['valid' => false, 'message' => 'This code has already been used.'], 400);
    }

    $layawaycode->update(['Iseen' => 1]);
    return response()->json(['valid' => true]);


    // $isValid = Layawaycode::where('layaway_code', $code)->exists();

    // return response()->json(['valid' => $isValid]);
}


}
