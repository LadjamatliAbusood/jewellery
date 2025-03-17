<?php

namespace App\Http\Controllers;

use App\Models\Layawaycode;
use Illuminate\Http\Request;

class ModalPasswordController extends Controller
{
    public function index(){
        $codes = Layawaycode::latest()->get();

        return view('product.modalpassword', compact('codes'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'modalpassword' => 'required|string|max:6',
        ]);
    
        // Find an existing record
        $code = Layawaycode::first();
    
        if ($code) {
            // Update the existing record and reset Iseen to 0
            $code->update([
                'layaway_code' => $request->modalpassword,
                'Iseen' => 0
            ]);
        } else {
            // If no record exists, create a new one
            Layawaycode::create([
                'layaway_code' => $request->modalpassword,
                'Iseen' => 0
            ]);
        }
    
        return redirect()->route('admin.modal-password')->with('success', 'Password saved successfully!');
    }
    
}
