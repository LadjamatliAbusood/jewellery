<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchViewController extends Controller
{
    protected $searchview;

    public function __construct(){
     $this -> searchview = new Product();
    }
 
    public function index(Request $request)
    {
        $query = $request->input('search');
        $searchview = $this->searchview
            ->when($query, function ($queryBuilder, $search) {
                return $queryBuilder->where('productname', 'LIKE', "%$search%")
                    ->orWhere('productcode', 'LIKE', "%$search%")
                    ->orWhereHas('supplier', function ($query) use ($search) {
                        $query->where('supplier_fullname', 'LIKE', "%$search%");
                    });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(250);
          
    
        return view('layout.searchview', compact('searchview'));
    }
}
