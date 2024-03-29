<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\PaymentmethodController;
use App\Http\Controllers\PaymentsaleController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');

// Handle form submission
Route::post('/departments/store', [DepartmentController::class, 'store'])->name('departments.store');


// Read (Index)

Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');

// Update (Edit and Update)
Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');


// Delete (Delete and Destroy)
Route::get('/departments/{department}/delete', [DepartmentController::class, 'deleteConfirmation'])->name('departments.delete');

Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');



// Search
Route::get('/departments/search', [DepartmentController::class, 'search'])->name('departments.search');

//staff
//register 
//Route::get('/staff/addstaff', [StaffController::class, 'showRegistrationForm'])->name('staff.addstaff');
//Route::post('/staff/addstaff', [StaffController::class, 'addstaff'])->name('staff.addstaff.submit');

// Read (Index)

Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');

// Update (Edit and Update)
// Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
// Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');

//delate staff

// Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');

//search staff

Route::get('/staff/search', [StaffController::class,  'search'])->name('staff.search');

Route::get('/shops/add_shop', [ShopController::class, 'view_shop'])->name('shop.add');
//sales
//register 
Route::get('/sales/addsales', [SaleController::class, 'create'])->name('sales.create');
//sales
//register 
Route::get('/sales/addsales', [SaleController::class, 'create'])->name('sales.create');

Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

// Read (Index)

Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');

// Update sales (Edit and Update)
Route::get('/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
Route::put('/sales/{sale}', [SaleController::class, 'update'])->name('sales.update');

// Delete (Delete and Destroy)
Route::get('/sales/{sale}/delete', [SaleController::class, 'deleteConfirmation'])->name('sales.delete_confirmation');
Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');

//search
Route::get('/sales/search', [SaleController::class, 'search'])->name('sales.search');



Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

// Read (Index)

Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');

// Update sales (Edit and Update)
Route::get('/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
Route::put('/sales/{sale}', [SaleController::class, 'update'])->name('sales.update');

// Delete (Delete and Destroy)
Route::get('/sales/{sale}/delete', [SaleController::class, 'deleteConfirmation'])->name('sales.delete_confirmation');
Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');

//search
Route::get('/sales/search', [SaleController::class, 'search'])->name('sales.search');



Route::post('/shops/add_shop', [ShopController::class, 'store'])->name('shop.store');

Route::get('/shops/view_all', [ShopController::class, 'view_all'])->name('shop.view');

//Route::delete('/shops/{shop}', [ShopController::class, 'destroy'])->name('shop.destroy');

Route::delete('/shops/{id}', [ShopController::class, 'destroy'])->name('shop.destroy');

Route::get('/shops/search', [ShopController::class, 'search'])->name('shop.search');

Route::get('/shops/{shop}/update_view', [ShopController::class, 'update_view'])->name('shop.update_view');

Route::put('/shops/{shop}', [ShopController::class, 'update'])->name('shop.update');

//Shifts

//Add
Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');

Route::get('/shifts/create', [ShiftController::class, 'create'])->name('shifts.create');
Route::post('/shifts', [ShiftController::class, 'store'])->name('shifts.store');

//Update
Route::get('/shifts/{id}/edit', [ShiftController::class, 'edit'])->name('shifts.edit');
Route::put('/shifts/{id}', [ShiftController::class, 'update'])->name('shifts.update');

//delete
Route::delete('/shifts/{id}', [ShiftController::class, 'destroy'])->name('shifts.destroy');

//search
// web.php
Route::get('/shifts/search', 'App\Http\Controllers\ShiftController@search')->name('shifts.search');



// staff shift search
Route::get('/shiftstaff/search', [ShiftController::class, 'directToSearch'])->name('shiftstaff.search');

Route::get('/shiftstaff/result', [ShiftController::class, 'searchStaffByDate'])->name('shiftstaff.results');

//shopsale seatch

Route::get('/shopsale/search', [SaleController::class, 'searchShopForm'])->name('shopsale.searchForm');
Route::post('/shopsale/searchresults', [SaleController::class, 'searchShopDetails'])->name('shopsale.searchResult');

//staff sale search
Route::get('/staffsale/search', [SaleController::class, 'searchStaffForm'])->name('staffsale.searchForm');
Route::post('/staffsale/result', [SaleController::class, 'searchStaffSales'])->name('staffsale.searchResult');

//Payment method
//creaete
Route::get('/paymentmethods/create', [PaymentmethodController::class, 'create'])->name('paymentmethod.create');
Route::post('/paymentmethods/store', [PaymentmethodController::class, 'store'])->name('paymentmethod.store');

//view
Route::get('/paymentmethods', [PaymentmethodController::class, 'index'])->name('paymentmethod.index');

//update
Route::get('/paymentmethods/{id}/edit', [PaymentmethodController::class, 'edit'])->name('paymentmethod.edit');
Route::put('/paymentmethods/{id}', [PaymentmethodController::class, 'update'])->name('paymentmethod.update');
//delete
Route::delete('/paymentmethods/{id}', [PaymentmethodController::class, 'destroy'])->name('paymentmethod.destroy');

//PaymentSale
//create
Route::get('/paymentsale/create', [PaymentsaleController::class, 'create'])->name('paymentsale.create');
Route::post('/paymentsale/store', [PaymentsaleController::class, 'store'])->name('paymentsale.store');

//view 
Route::get('/paymentsales', [PaymentSaleController::class, 'index'])->name('paymentsales.index');

//edit
Route::get('/paymentsales/{id}/edit', [PaymentSaleController::class, 'edit'])->name('paymentsales.edit');
Route::put('/paymentsales/{id}', [PaymentSaleController::class, 'update'])->name('paymentsales.update');



Route::delete('/paymentsales/{id}', [PaymentSaleController::class, 'destroy'])->name('paymentsales.destroy');


//FINAL ==============================================================================

 Route::get('/', [AuthController::class, 'login'])->name('auth.login');
 Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
// Route::post('/login', 'AuthController@authenticate')->name('login');

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');


//STAFF REGISTRATION =================================================================
Route::get('/pages/staff/addstaff', [StaffController::class, 'addstaff'])->name('staff.addstaff');
Route::post('/pages/staff/addstaff', [StaffController::class, 'addstaff'])->name('staff.addstaff.submit');

//STAFF UPDATE =======================================================================
Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');


//STAFF DELETE =======================================================================
Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');



