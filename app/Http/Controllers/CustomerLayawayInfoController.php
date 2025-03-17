<?php

namespace App\Http\Controllers;

use App\Models\CustomerLayawayInfo;
use App\Models\Customerpayment;
use App\Models\CustomerStorage;
use App\Models\Layawaycode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerLayawayInfoController extends Controller
{
    protected $customerlayawayinfo;

    public function __construct(){
        $this->customerlayawayinfo = new CustomerLayawayInfo();
    }
    public function index(){
        
        $Customerlayawayinfo = CustomerLayawayInfo::with('storage')->latest()->get();
   
       return view('layout.layaway', compact('Customerlayawayinfo'));
       }

    public function store(Request $request){

        if (CustomerLayawayInfo::where('customer_number', $request->customer_number)->exists()) {
             return redirect()->back()->with('error', 'Customer number already exists.');
        }

        $request->validate([
            'customer_number' => 'required|numeric',
            'fullname' => 'required|string|max:255',
            'customer_cn' => 'required|numeric',
            'layaway_info' => 'required|string|max:255',
            'sellingprice' => 'required|numeric',
            'downpayment' => 'required|numeric',
            'plan' => 'required|in:1,2,3,4',
            'description' => 'required|string|max:255',
        ]);

         // Create a new entry in customer_layaway_info
    $layaway = CustomerLayawayInfo::create([
        'customer_number' => $request->customer_number,
        'fullname' => $request->fullname,
        'customer_cn' => $request->customer_cn,
        'layaway_info' => $request->layaway_info,
        'sellingprice' => $request->sellingprice,
        'downpayment' => $request->downpayment,
        'plan' => $request->plan,
        'description' => $request->description,
    ]);

    // Calculate balance (Selling Price - Down Payment)
    $balance = $request->sellingprice - $request->downpayment;

     // Create a new entry in customerstorage using layaway_id
     CustomerStorage::create([
        'account' => $request->account,
        'layaway_id' => $layaway->id, // Foreign key reference
        'customername' => $request->fullname,
        'sellingprice' => $request->sellingprice,
        'downpayment' => $request->downpayment,
        'balance' => $balance,
        'status' => 1, // Default status (e.g., new)
    ]);

    Customerpayment::create([
        'layaway_id' => $layaway->id, // Foreign key reference
        'amount' => $request->downpayment,
        'balance' => $balance,
    ]);
    
    
       return redirect()->back()->with('success', 'Layaway successfully Added');
    
    }

    public function edit($id)
    {
     // Assuming you want to find the layaway by ID
     $layaway = CustomerLayawayInfo::findOrFail($id);

     // Retrieve the related data, for example, all layaway info for a customer
     $Customerlayawayinfo = CustomerLayawayInfo::where('id', $layaway->id)->get();
     $CustomerPayment = Customerpayment::where('layaway_id', $layaway->id)
     ->orderBy('created_at', 'desc')->get();;
        // Return the edit view with the layaway data
        $codes = Layawaycode::orderBy('created_at', 'desc')->get();
        return view('layout.layawayedit', compact('Customerlayawayinfo','layaway','CustomerPayment','codes'));
    }


    public function updatePayment(Request $request, $id) {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
    
        // Get the layaway information
        $layaway = CustomerLayawayInfo::findOrFail($id);
    
        // Get the current storage info (layaway-related payment details)
        $storage = $layaway->storage;
    
        if (!$storage) {
            return redirect()->back()->with('error', 'Storage record not found.');
        }
    
        // Get the current downpayment and balance
        $current_downpayment = $storage->downpayment;
        $current_balance = $storage->balance;
    
        // Calculate the new downpayment and balance after adding the payment
        $new_downpayment = $current_downpayment + $request->amount;
        $new_balance = $layaway->sellingprice - $new_downpayment;
    
        // Create the new payment record
        $payment = new Customerpayment();
        $payment->layaway_id = $layaway->id;
        $payment->amount = $request->amount;
        $payment->balance = $new_balance;
        $payment->save();
    
        // Update the downpayment and balance in the storage
        $storage->downpayment = $new_downpayment;
        $storage->balance = $new_balance;
    
        $layaway->downpayment = $new_downpayment;
        $layaway->save();  // Save the updated downpayment in the customer_layaway_info table
    
        // Update the status based on the balance
        if ($new_balance == 0) {
            $storage->status = 3; // Fully Paid
        } else {
            $storage->status = 2; // Ongoing
        }
    
        // Save the updated storage info
        $storage->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Layaway payment successfully added.');
    }
    

    public function updateExpiredLayaways()
{
    $layaways = CustomerLayawayInfo::whereHas('storage', function ($query) {
        $query->where('status', '!=', 5);
    })->get();

    foreach ($layaways as $layaway) {
        $expirationDate = match ($layaway->plan) {
            1 => Carbon::parse($layaway->created_at)->addDays(15),
            2 => Carbon::parse($layaway->created_at)->addMonths(3),
            4 => Carbon::parse($layaway->created_at)->addMonths(4),
            5 => Carbon::parse($layaway->created_at)->addMonths(6),
            default => null,
        };

        if ($expirationDate && Carbon::now()->greaterThan($expirationDate)) {
            CustomerStorage::where('layaway_id', $layaway->id)
                ->where('status', '!=', 5)
                ->update(['status' => 5]);
        }
    }

    return redirect()->back()->with('success', 'Expired layaways updated successfully.');
}
    
    
public function updateLayawayDetails(Request $request, $layawayId)
{
    $request->validate([
        'sellingprice' => 'required|numeric|min:1',
        'description' => 'nullable|string',
    ]);

    // Get layaway details
    $layaway = CustomerLayawayInfo::findOrFail($layawayId);
    $oldSellingPrice = $layaway->sellingprice;
    $newSellingPrice = (float) str_replace(',', '', $request->sellingprice);

    // Get associated storage record
    $storage = CustomerStorage::where('layaway_id', $layaway->id)->first();

    if (!$storage) {
        return back()->with('error', 'Storage record not found.');
    }

    // Calculate new balance
    $newBalance = max($newSellingPrice - $storage->downpayment, 0);

    // Update layaway table
    $layaway->update([
        'sellingprice' => $newSellingPrice,
        'layaway_info' => $request->description,
    ]);

    // Update customer storage table
    $storage->update([
        'sellingprice' => $newSellingPrice,
        'balance' => $newBalance,
        'updated_at' => now(),
    ]);

    // Get all payments for this layaway
    $payments = CustomerPayment::where('layaway_id', $layaway->id)->orderBy('created_at')->get();

    // Recalculate payment balances
    $totalPaid = 0;
    foreach ($payments as $payment) {
        $totalPaid += $payment->amount;
        $remainingBalance = max($newSellingPrice - $totalPaid, 0);

        // Update payment record
        $payment->update([
            'balance' => $remainingBalance,
        ]);
    }


    return back()->with('success', 'Selling price and payments updated successfully.');
}


public function verifyCode(Request $request)
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
