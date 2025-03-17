<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\GoldModel;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductHistory;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
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
     

       return view('product.index',compact('products','suppliers','allProductCodes','goldtype','gold'));

      
  
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->product->find($id);
       $suppliers = Supplier::where('status',1)->pluck('supplier_fullname', 'id');
       $gold = GoldModel::where('status', 1)->pluck('gold_type', 'id');
       return view('product.edit',compact('product','suppliers','gold'));
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
           
            'supplier_id' => 'required|exists:suppliers,id',
            'productcode' => 'required|string|max:255',
            'productname' => 'required|string|max:255',
          
            'cost_per_gram' => 'required|numeric',
            'price_per_gram' => 'required|numeric',
            'grams' => 'required|numeric',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
    
        $product = $this->product->findOrFail($id);
        
        $newQuantity = $product->quantity + $request->input('quantity');

        // Update the product
        $product->update([
            'gold_id' => $request->input('gold_id'),
            'supplier_id' => $request->input('supplier_id'),
            'productcode' => $request->input('productcode'),
            'productname' => $request->input('productname'),
            'quantity' => $newQuantity, // Update the quantity with the incremented value
            'cost_per_gram' => $request->input('cost_per_gram'),
            'price_per_gram' => $request->input('price_per_gram'),
            'grams' => $request->input('grams'),
            'cost' => $request->input('cost'),
            'price' => $request->input('price'),
        ]);
        
     
    // Store product history
        ProductHistory::create(array_merge($product->toArray(), ['product_id' => $product->id]));
    
        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->product->find($id);
        $product->delete();
        return redirect('admin/product')->with('success', 'Product Deleted Successfully');
        
    }

    public function exportProducts(){
        return Excel::download(new ProductExport,'products.xls');
    }
  
}
