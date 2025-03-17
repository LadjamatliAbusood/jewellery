<?php

namespace App\Http\Controllers;

use App\Models\LayawayModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LayawayContoller extends Controller
{
    protected $layaway;

    public function __construct(){
        $this->layaway = new LayawayModel();
    }
    public function index(Request $request, $id = null){
        $filterDate = $request->get('filter_date');
    $layaway = $filterDate 
        ? LayawayModel::whereDate('created_at', $filterDate)->paginate(10)
        : LayawayModel::paginate(10)
        ->orderBy('created_at', 'DESC');
        $editLayaway = $id ? LayawayModel::find($id) : null;
       
        return view('layout.layaway', compact('layaway' ,'editLayaway'));
    }

    public function store(Request $request){
        $request->validate([
            'account' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'downpayment' => 'required|numeric',
        ]);
        $this->layaway->create($request->all());
       return redirect()->back()->with('success', 'Layaway successfully Added');
    
    }
       public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'downpayment' => 'required|numeric',
        ]);

        $layaway = LayawayModel::findOrFail($id);
        $layaway->update($request->only('description', 'downpayment'));

        return redirect()->route('cashier.layaway.index')->with('success', 'Layaway successfully updated');
    }

}
