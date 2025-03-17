<?php

namespace App\Http\Controllers;

use App\Models\GoldModel;
use Illuminate\Http\Request;

class GoldController extends Controller
{

    protected $gold;
    
    public function __construct(){
        $this -> gold = new GoldModel();

    }

    public function index(){
  
        $Gold = $this->gold->all();
        return view('product.goldtype', compact('Gold'));
    }
    public function store(Request $request){
        $request->validate([
           'gold_type' => 'required|string|max:255',
           'gold_cost' => 'required|numeric',
           'gold_price' => 'required|numeric',
           'status' => 'required|in:1,2',
       ]);
      $this->gold->create($request->all());
      return redirect()->back()->with('success', 'registered successfully!');
     }

     public function edit($id)
     {
         $Gold = $this->gold->all();
         $editingGold = $this->gold->findOrFail($id);
         return view('product.goldtype', compact('Gold', 'editingGold'));
     }
     public function update(Request $request, $id)
     {
         $request->validate([
            'gold_type' => 'required|string|max:255',
            'gold_cost' => 'required|numeric',
            'gold_price' => 'required|numeric',
            'status' => 'required|in:1,2',
         ]);
     
         $Gold = $this->gold->findOrFail($id);
         $Gold->update($request->only('gold_type','gold_cost','gold_price', 'status'));
     
         return redirect()->route('goldtype')->with('success', 'Updated successfully!');
     }
}
