<?php

namespace App\Http\Controllers;

use App\Models\CustomerLayawayInfo;
use App\Models\Customerpayment;
use App\Models\CustomerStorage;
use App\Models\LayawayCode;

use App\Models\LayawayModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminLaywayController extends Controller
{
    protected $customerlayawayinfo;

    public function __construct(){
        $this->customerlayawayinfo = new CustomerLayawayInfo();
    }
    public function index(Request $request, $id = null){

        $Customerlayawayinfo = CustomerLayawayInfo::with('storage')->latest()->get();
       
        return view('admin.layawayadmin', compact('Customerlayawayinfo'));
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
        return view('admin.layawayeditadmin', compact('Customerlayawayinfo','layaway','CustomerPayment'));
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
    
    
    
    public function cancelLayaway(Request $request, $id)
    {
          // Get the layaway information
    $layaway = CustomerLayawayInfo::findOrFail($id);
    
    // Get the related storage for this layaway
    $storage = $layaway->storage;

    // Check if the storage exists and then update the status
    if ($storage) {
        // Update the status to 4 (Canceled)
        $storage->status = 4;
        $storage->save();

        // Optionally, you could add a message or log for confirmation
        return redirect()->back()->with('success', 'Layaway has been canceled.');
    }
    
    // If no storage is found, show an error message
    return redirect()->back()->with('error', 'Layaway storage not found.');
    }


  
}
