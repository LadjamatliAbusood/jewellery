<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AccountController extends Controller
{


    protected $user;

    public function __construct(){
     $this -> user = new User();
    }
 
    public function index()
    {
        $users = $this->user->all();
        return view('auth.accountRegister', compact('users'));
    }


    public function register(){
        return view('auth.accountRegister');
    }
    

    public function registerSave(Request $request){
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',  // Make sure email is unique
            'password' => 'required|min:2',
            'type' => 'required|in:0,1,2',  // Cashier (0), Admin (1), Manager (2)
        ])->validate();
    
        // Create new user (cashier or manager)
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
           'type' => (int)$request->type,  // Ensure the type is stored as an integer
        ]);
    
        return redirect('admin/register')->with('success', 'Account created successfully');

    }



    public function destroy(string $id){
        $users = $this->user->find($id);
        $users->delete();
        return redirect('admin/register')->with('success', 'Account deleted successfully');
     }
}
