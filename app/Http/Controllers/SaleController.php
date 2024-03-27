<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PaymentsaleController;
use App\Models\Paymentsale;
use Illuminate\Support\Facades\Log;

use App\Models\Sale;  
use App\Models\Department;
use App\Models\Staff;
use App\Models\Shop;
use App\Models\Shift;

use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        // Fetch staff from the database
        $sales= Sale::all();

        // Pass the staff variable to the view
        return view('sales.index', compact('sales'));
    }
   

    public function create()
    {
        $departments = Department::all();
        $shops = Shop::all();
        $staffs = Staff::all();

    
        return view('sales.addsales', compact('departments', 'shops', 'staffs'));
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'dept_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
            'shop_id' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        // Check if a record with the same department, date, shop and staff exists
        $existingSale = Sale::where('dept_id', $validatedData['dept_id'])
                            ->where('staff_id', $validatedData['staff_id'])
                            ->where('shop_id', $validatedData['shop_id'])
                            ->whereDate('created_at', now()->toDateString())
                            ->first();

        if ($existingSale) {
            // Update the existing record
            $existingSale->amount += $validatedData['amount'];
            $existingSale->save();
        } else {
            // Create a new record
            Sale::create($validatedData);
        }
        
        return redirect()->route('sales.create')->with('success', 'Sale added successfully!');

    }

    public function edit($id)
    {
        // Retrieve the sale record you want to edit
        $sale = Sale::findOrFail($id);

        // Fetch departments, staffs, and shops
        $departments = Department::all();
        $staffs = Staff::all();
        $shops = Shop::all();

        // Pass the data to the view
        return view('sales.edit', compact('sale', 'departments', 'staffs', 'shops'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validatedData = $request->validate([
            'dept_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
            'shop_id' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $sale->update($validatedData);

        return redirect()->route('sales.index')->with('success', 'Sales details updated successfully!');
    }

    public function deleteConfirmation($id)
    {
        $sale = Sale::findOrFail($id);
        return view('sales.delete', compact('sale'));
    }
    

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sales details deleted successfully!');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Perform a database query to search for sales records based on the foreign key names
        $sales = Sale::select('sales.*', 'departments.dept_name', 'staffs.staff_name', 'shops.name as shop_name')
                    ->join('departments', 'sales.dept_id', '=', 'departments.id')
                    ->join('staffs', 'sales.staff_id', '=', 'staffs.id')
                    ->join('shops', 'sales.shop_id', '=', 'shops.id')
                    ->where('departments.dept_name', 'like', "%$keyword%")
                    ->orWhere('staffs.staff_name', 'like', "%$keyword%")
                    ->orWhere('shops.name', 'like', "%$keyword%")
                    ->get();

        // Pass the search results to the view
        return view('sales.search', ['sales' => $sales]);
    }

    

    public function searchShopForm()
{
    $shops = Shop::all();
    return view('shopsale.search', compact('shops'));
}

public function searchShopDetails(Request $request)
{
    // Retrieve search parameters from the request
    $shopId = $request->input('shop_id');
    $date = $request->input('date');

    // Parse the date using Carbon for proper handling
    $parsedDate = Carbon::parse($date)->startOfDay();

    // Query sales records based on the shop ID and date
    $sales = Sale::where('shop_id', $shopId)
                ->whereDate('created_at', $parsedDate)
                ->get();

    // Return the view with the search results
    return view('shopsale.searchresults', compact('sales'));
}
    
public function searchStaffForm()
{
    $staffs = Staff::all();
    return view('staffsale.search', compact('staffs'));
}

public function searchStaffSales(Request $request)
{
    $staffId = $request->input('staff_id');
    $date = $request->input('date');

    $parsedDate = Carbon::parse($date)->startOfDay();

    $sales = Sale::where('staff_id', $staffId)
                ->whereDate('created_at', $parsedDate)
                ->get();

    $paymentSales = PaymentSale::where('staff_id', $staffId)
                ->whereDate('created_at', $parsedDate)
                ->get();

    return view('staffsale.result', compact('sales','paymentSales'));
}

// public function getSalesDetails($shiftId)
//     {
//         $departments = Department::all();
//         try {
//             // Fetch sales details based on the shift ID
//             $salesDetails = Sale::where('shift_id', $shiftId)->get();

//             // Check if it's an AJAX request
//             if (request()->ajax()) {
//                 // Return sales details as JSON for AJAX requests
//                 return response()->json(['salesDetails' => $salesDetails]);
//             }

//             // Return the initial page with sales details
//             return view('pages.sales.editsale', compact('salesDetails','departments'));
//         } catch (\Exception $e) {
//             // Log the error
//             \Log::error('Error fetching sales details: ' . $e->getMessage());

//             // Return error response
//             return response()->json(['error' => 'An error occurred while fetching sales details.'], 500);
//         }
//     }
public function getSalesDetails($shiftId)
{
    $departments = Department::all();
    try {
        // Fetch sales details based on the shift ID
        $salesDetails = Sale::where('shift_id', $shiftId)->get();

        // Check if it's an AJAX request
        if (request()->ajax()) {
            // Return sales details as JSON for AJAX requests
            return response()->json(['salesDetails' => $salesDetails, 'departments' => $departments]);
        }

        // Return the initial page with sales details
        return view('pages.sales.editsale', compact('salesDetails', 'departments'));
    } catch (\Exception $e) {
        // Log the error
        Log::error('Error fetching sales details: ' . $e->getMessage());

        // Return error response
        return response()->json(['error' => 'An error occurred while fetching sales details.'], 500);
    }
}





}
