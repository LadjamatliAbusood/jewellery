<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
   protected $supplier;

   public function __construct(){
    $this -> supplier = new Supplier();
   }

   public function index()
   {
       $Suppliers = $this->supplier->all();
       return view('supplier.index', compact('Suppliers'));
   }
   public function store(Request $request){
      $request->validate([
         'supplier_fullname' => 'required|string|max:255',
         'status' => 'required|in:1,2',
     ]);
    $this->supplier->create($request->all());
    return redirect()->back()->with('success', 'Supplier registered successfully!');
   }

   public function edit($id)
   {
       $Suppliers = $this->supplier->all();
       $editingSupplier = $this->supplier->findOrFail($id);
       return view('supplier.index', compact('Suppliers', 'editingSupplier'));
   }
   public function update(Request $request, $id)
   {
       $request->validate([
           'supplier_fullname' => 'required|string|max:255',
           'status' => 'required|in:1,2',
       ]);
   
       $supplier = $this->supplier->findOrFail($id);
       $supplier->update($request->only('supplier_fullname', 'status'));
   
       return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully!');
   }

   public function destroy(string $id){
      $supplier = $this->supplier->find($id);
      $supplier->delete();
      return redirect('admin/supplier')->with('success', 'Supplier deleted successfully');
   }
}
