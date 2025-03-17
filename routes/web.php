<?php

use App\Exports\ProductExport;
use App\Exports\ProductHistoryExport;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminExpensesController;
use App\Http\Controllers\AdminLaywayController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierAddProductController;
use App\Http\Controllers\CustomerLayawayInfoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatabaseExportController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\GoldCalculateController;
use App\Http\Controllers\GoldController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayawayCodeController;
use App\Http\Controllers\LayawayContoller;
use App\Http\Controllers\ModalPasswordController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductHistoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesDetailsController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\SearchViewController;
use App\Models\Layawaycode;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('auth.login');});


// Route::controller(AccountController::class)->group(function(){
//     Route::get('register','register')->name('register');
//     Route::post('register','registerSave')->name('register.save');
 

// });

Route::controller(AuthController::class)->group(function(){
    Route::get('login','login')->name('login');
    Route::post('login','loginAction')->name('login.action');
    Route::get('logout','logout')->middleware('auth')->name('logout');



});


Route::post('/search',[SalesController::class, 'search'])->name('search');
Route::post('/sales_add',[SalesController::class, 'store'])->name('sales_add');



  
//search
Route::get('/home/search', [SearchViewController::class, 'index'])->name('layout.searchview');

//user Routes
Route::middleware('auth','user-access:cashier')->group(function(){
    Route::get('/home',[HomeController::class,'index'])->name('home');
    Route::get('/point-of-sale', function () {return view('cashier.index');});
    Route::get('home/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    
    //Cashier Product
    Route::resource('home/add-product', CashierAddProductController::class);
    Route::post('/product-password',[CashierAddProductController::class,'verifyPassword']);
//   //Layaway
//   Route::get('home/layaway', [LayawayContoller::class, 'index'])->name('cashier.layaway.index');
//   Route::post('home/layaway',[LayawayContoller::class, 'store'])->name('cashier.layaway.store');
//   Route::get('home/layaway/edit/{id}', [LayawayContoller::class, 'index'])->name('cashier.layaway.edit');
//   Route::post('home/layaway/update/{id}', [LayawayContoller::class, 'update'])->name('cashier.layaway.update');



  //Layaway
  Route::get('home/layaway', [CustomerLayawayInfoController::class, 'index'])->name('cashier.layaway.index');
  Route::post('home/layaway',[CustomerLayawayInfoController::class, 'store'])->name('cashier.layaway.store');
  Route::get('home/layaway/edit/{id}', [CustomerLayawayInfoController::class, 'edit'])->name('cashier.layawayedit');
//   Route::post('home/layaway/update/{id}', [CustomerLayawayInfoController::class, 'update'])->name('cashier.layaway.update');
  //Route::put('home/layaway/update/{id}', [CustomerLayawayInfoController::class, 'updatePlan'])->name('cashier.updatePlan');
  Route::put('home/layaway/{id}/update-payment', [CustomerLayawayInfoController::class, 'updatePayment'])->name('cashier.updatePayment');
  Route::get('home/update-layaways', [CustomerLayawayInfoController::class, 'updateExpiredLayaways'])->name('updateLayaways');


  Route::post('/validate-layaway-code',[CustomerLayawayInfoController::class,'verifyCode']);


  
  Route::put('/cashier/update-layaway-details/{id}', [CustomerLayawayInfoController::class, 'updateLayawayDetails'])
    ->name('cashier.updateLayawayDetails');

  //Expenses
Route::get('home/expenses', [ExpensesController::class, 'index'])->name('cashier.expenses.index');
Route::post('home/expenses',[ExpensesController::class, 'store'])->name('cashier.expenses.store');



    
});
//=======================================================================================================
//Admin Routes  
Route::middleware(['auth', 'user-access:admin'])->group(function() {
Route::get('/admin/home', [HomeController::class, 'adminhome'])->name('admin/home');
Route::resource('/admin/product', ProductController::class);

//History Route
Route::get('/admin/history', [ProductHistoryController::class, 'index'])->name('history');

//Sales Report Route
Route::get('/admin/sales-report', [SalesReportController::class, 'index'])->name('sales-report');

//Supplier Route
Route::get('/admin/supplier', [SupplierController::class, 'index'])->name('supplier.index');
Route::post('supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::put('supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('admin/supplier/destroy/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

//Account
Route::get('/admin/register', [AccountController::class, 'register'])->name('register');//Register Form
Route::post('admin/register', [AccountController::class, 'registerSave'])->name('register.save');//Save Registration
// Route::get('register', [AccountController::class, 'register'])->name('auth.accountRegister');
Route::get('/admin/register', [AccountController::class, 'index']); // List users;
Route::delete('admin/register/destroy/{id}', [AccountController::class, 'destroy'])->name('register.destroy');//Delete User

//dashboard
// Route::get('', [SalesDetailsController::class, 'index'])->name('dashboard.dashtable');


//Sales
Route::get('/admin/pos', [SalesController::class, 'index'])->name('pos');


//Export Product History
Route::get('/export-product-history', function (Request $request) {
    $dateFrom = $request->input('date_from');
    $dateTo = $request->input('date_to');
    return Excel::download(new ProductHistoryExport($dateFrom, $dateTo), 'product_history.xlsx');
})->name('export.product.history');

//Export Product
Route::get('/export-products', function () {
    return Excel::download(new ProductExport, 'products.xlsx');
})->name('export.products');
Route::get('/export-products', [ProductController::class, 'exportProducts'])->name('export.products');

//Export Sales
Route::get('/export-sales', [SalesReportController::class, 'export'])->name('export.sales');
//Export the database
Route::get('/export-database', [DatabaseExportController::class, 'export'])->name('export.database');




// //Layaway
// Route::get('admin/layaway', [AdminLaywayController::class, 'index'])->name('admin.layaway.index');
// Route::post('admin/layaway',[AdminLaywayController::class, 'store'])->name('admin.layaway.store');
// Route::get('admin/layaway/edit/{id}', [AdminLaywayController::class, 'index'])->name('admin.layaway.edit');
// Route::post('admin/layaway/update/{id}', [AdminLaywayController::class, 'update'])->name('admin.layaway.update');

// //Layaway admin
Route::get('admin/layaway', [AdminLaywayController::class, 'index'])->name('admin.layaway.index');
Route::post('admin/layaway',[AdminLaywayController::class, 'store'])->name('admin.layaway.store');
Route::get('admin/layaway/edit/{id}', [AdminLaywayController::class, 'edit'])->name('admin.layawayeditadmin');
//   Route::post('home/layaway/update/{id}', [CustomerLayawayInfoController::class, 'update'])->name('cashier.layaway.update');
//Route::put('home/layaway/update/{id}', [CustomerLayawayInfoController::class, 'updatePlan'])->name('cashier.updatePlan');
Route::put('admin/layaway/{id}/update-payment', [AdminLaywayController::class, 'updatePayment'])->name('admin.updatePayment');
Route::put('admin/layaway/{id}/cancel', [AdminLaywayController::class, 'cancelLayaway'])->name('cancelLayaway');


//Expenses
Route::get('admin/expenses', [AdminExpensesController::class, 'index'])->name('admin.expenses.index');
Route::post('admin/expenses',[AdminExpensesController::class, 'store'])->name('admin.expenses.store');

//Gold Type
Route::get('admin/gold', [GoldController::class, 'index'])->name('goldtype');
Route::post('gold', [GoldController::class, 'store'])->name('gold.store');
Route::get('gold/edit/{id}', [GoldController::class, 'edit'])->name('gold.edit');
Route::put('gold/update/{id}', [GoldController::class, 'update'])->name('gold.update');

//Gold Calculate
Route::get('admin/gold-calculate', [GoldCalculateController::class, 'index'])->name('gold-calculate');


//Modal Password
Route::get('admin/modal-password', [ModalPasswordController::class, 'index'])->name('admin.modal-password');
Route::post('admin/modal-password/store', [ModalPasswordController::class, 'store'])->name('admin.modal-password.store');

});

