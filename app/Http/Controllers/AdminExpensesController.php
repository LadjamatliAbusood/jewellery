<?php

namespace App\Http\Controllers;

use App\Models\expenses;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminExpensesController extends Controller
{
    protected $expenses;

    public function __construct(){
        $this->expenses = new expenses();
    }


    public function index(Request $request, $id = null){
        $filterDate = $request->get('filter_date');
    $expenses = $filterDate 
        ? Expenses::whereDate('created_at', $filterDate)->paginate(10)
        : Expenses::latest()->paginate(15);
        $editexpenses = $id ? Expenses::find($id) : null;
       
        return view('admin.expensesadmin', compact('expenses' ,'editexpenses'));
    }


 
    public function store(Request $request){
        $request->validate([
            'account' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'total_expenses' => 'required|numeric',
        ]);
        $this->expenses->create($request->all());
       return redirect()->back()->with('success', 'Expenses successfully Added');
    
    }
}
