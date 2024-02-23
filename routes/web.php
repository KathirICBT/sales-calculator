<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SaleController;

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
Route::get('/staff/addstaff', [StaffController::class, 'showRegistrationForm'])->name('staff.addstaff');
Route::post('/staff/addstaff', [StaffController::class, 'addstaff'])->name('staff.addstaff.submit');

// Read (Index)

Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');

// Update (Edit and Update)
Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');

//delate staff

Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');

//search staff

Route::get('/staff/search', [StaffController::class,  'search'])->name('staff.search');

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




Route::get('/', function () {
    return view('departments.create');
});
