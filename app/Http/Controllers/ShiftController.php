<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Shop;
use App\Models\Staff;
use Carbon\Carbon;
use App\Models\Paymentmethod;
use App\Models\PettyCashReason;
use App\Models\Paymentsale;
use App\Models\Sale; // Import Sale model
use App\Models\Department;
use App\Models\Petticash;
use App\Models\Cashdiffer;
use Illuminate\Support\Facades\DB; 


class ShiftController extends Controller
{    
    public function create()
    {
        // Fetch shops and staffs to populate dropdown menus
        $shops = Shop::all();
        $staffs = Staff::all();
        $paymentMethods = Paymentmethod::all(); 
        return view('shifts.create', compact('shops', 'staffs','paymentMethods'));
    }

    protected $currentShiftId;

// public function storeShifts(Request $request)
//     {       

//         if ($request->isMethod('post')) {
            
//             $request->validate([
//                 'shop_id' => 'required|numeric',
//                 'staff_id' => 'required|numeric',
//                 'start_date' => 'required|date',
//                 'end_date' => 'required|date|after_or_equal:start_date',
//                 'start_time' => 'required',
//                 'end_time' => [
//                     'required',
//                     function ($attribute, $value, $fail) use ($request) {                    
//                         $startDate = Carbon::parse($request->input('start_date'));
//                         $endDate = Carbon::parse($request->input('end_date'));
//                         $startTime = Carbon::parse($request->input('start_time'));
//                         $endTime = Carbon::parse($value);    
                        
//                         if ($startDate->eq($endDate) && $endTime->lte($startTime)) {
//                             $fail('The end time must be after the start time when the start and end dates are the same.');
//                         }
//                     },
//                 ],
//                 'total_amount' => 'required|numeric|min:0', // Add validation for total amount
//             ]);

//             // Parse the start and end dates
//             $startDate = Carbon::parse($request->input('start_date'));
//             $endDate = Carbon::parse($request->input('end_date'));

//             // Create the Shift model instance with specific fields
//             $shift = new Shift();
//             $shift->shop_id = $request->input('shop_id');
//             $shift->staff_id = $request->input('staff_id');
//             $shift->start_date = $startDate; // Assign the parsed start date directly
//             $shift->end_date = $endDate; // Assign the parsed end date directly
//             $shift->start_time = $request->input('start_time');
//             $shift->end_time = $request->input('end_time');
//             $shift->total_amount = $request->input('total_amount'); // Store the total amount
//             $shift->save();

//             $this->currentShiftId = $shift->id;
//             //return redirect()->route('shifts.index')->with('success', 'Shift added successfully!');
//             return "Shift Saved Successfully!";
//         }

//     $shops = Shop::all();
//     $staffs = Staff::all();
//     $shifts = Shift::all();
//     $departments = Department::all();
//     $paymentMethods = Paymentmethod::all(); 
//     return view('pages.sales.create', compact('shops', 'staffs','shifts','departments','paymentMethods'));
// }

// NEW WITH CASH BALANCE =======================================================================================
public function storeShifts(Request $request)
{
    if ($request->isMethod('post')) {
        
        $request->validate([
            'shop_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {                    
                    $startDate = Carbon::parse($request->input('start_date'));
                    $endDate = Carbon::parse($request->input('end_date'));
                    $startTime = Carbon::parse($request->input('start_time'));
                    $endTime = Carbon::parse($value);    
                    
                    if ($startDate->eq($endDate) && $endTime->lte($startTime)) {
                        $fail('The end time must be after the start time when the start and end dates are the same.');
                    }
                },
            ],
            'total_amount' => 'required|numeric|min:0', // Validation for total amount
            'cash_balance' => 'required|numeric|min:0', // Validation for cash balance
        ]);

        // Parse the start and end dates
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        // Create the Shift model instance with specific fields
        $shift = new Shift();
        $shift->shop_id = $request->input('shop_id');
        $shift->staff_id = $request->input('staff_id');
        $shift->start_date = $startDate; // Assign the parsed start date directly
        $shift->end_date = $endDate; // Assign the parsed end date directly
        $shift->start_time = $request->input('start_time');
        $shift->end_time = $request->input('end_time');
        $shift->total_amount = $request->input('total_amount'); // Store the total amount
        $shift->cash_balance = $request->input('cash_balance'); // Store the cash balance
        $shift->save();

        // Set the current shift ID for reference (if needed)
        $this->currentShiftId = $shift->id;
        
        // Return a success message
        return redirect()->route('shifts.index')->with('success', 'Shift added successfully!');
    }

    // If not a POST request, return the view with data for form
    $shops = Shop::all();
    $staffs = Staff::all();
    $shifts = Shift::all();
    $departments = Department::all();
    $paymentMethods = Paymentmethod::all(); 
    return view('pages.sales.create', compact('shops', 'staffs', 'shifts', 'departments', 'paymentMethods'));
}



public function update(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'shop_id' => 'required',
        'date' => 'required|date',
        'start_time' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'end_time' => [
            'required',
            function ($attribute, $value, $fail) use ($request) {                    
                $startDate = Carbon::parse($request->input('start_date'));
                $endDate = Carbon::parse($request->input('end_date'));
                $startTime = Carbon::parse($request->input('start_time'));
                $endTime = Carbon::parse($value);    
                
                if ($startDate->eq($endDate) && $endTime->lte($startTime)) {
                    $fail('The end time must be after the start time when the start and end dates are the same.');
                }
            },
        ],
    ]);

    // Find the shift by ID
    $shift = Shift::findOrFail($id);

    // Update the shift details
    $shift->shop_id = $request->input('shop_id');
    $shift->date = $request->input('date');
    $shift->start_time = $request->input('start_time');
    $shift->end_time = $request->input('end_time');
    $shift->start_date = $request->input('start_date');
    $shift->end_date = $request->input('end_date');

    // Save the updated shift
    $shift->save();

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Shift details updated successfully.');
}



    public function showShift($id)
    {
        $shift = Shift::find($id); // Assuming you're fetching the shift from the database
        return view('shifts.show', compact('shift'));
    }

    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->delete();

        return redirect()->route('shifts.show')->with('success', 'Shift deleted successfully!');
    }
    

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        // Perform your search logic here
        $shifts = Shift::whereHas('shop', function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        })->orWhereHas('staff', function ($query) use ($searchTerm) {
            $query->where('staff_name', 'like', '%' . $searchTerm . '%');
        })->get();

        return view('shifts.search', compact('shifts'));
    }


    public function searchStaffByDate(Request $request)
    {
        // Retrieve the date or date range from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Parse dates using Carbon for proper handling
        $parsedStartDate = Carbon::parse($startDate)->startOfDay();
        $parsedEndDate = Carbon::parse($endDate)->endOfDay();

        // Query shifts based on the date range
        $shifts = Shift::whereBetween('created_at', [$parsedStartDate, $parsedEndDate])->get();

        // Initialize an empty array to store staff details
        $staffDetails = [];

        // Iterate through each shift and retrieve staff details
        foreach ($shifts as $shift) {
            // Retrieve the staff details based on the staff_id in the Shift table
            $staff = Staff::find($shift->staff_id);

            // If staff details are found, add them to the staffDetails array
            if ($staff) {
                $staffDetails[] = [
                    'staff_name' => $staff->staff_name,
                    'shift_date' => $shift->created_at->toDateString(), // Assuming 'created_at' represents the shift date
                ];
            }
        }

        return view('pages.sales.editsale', compact('staffDetails'));
    }

    public function searchshift(Request $request)
{
    $username = $request->input('username');

    // Query shifts based on the staff username
    $staffDetails = Shift::whereHas('staff', function ($query) use ($username) {
        $query->where('username', $username);
    })->with(['staff', 'shop'])->get();
    $salesDetails= Sale::all();

    return view('pages.sales.editsale', ['staffDetails' => $staffDetails],['salesDetails'=>$salesDetails]);
}

public function directToSearch()
{
    // Retrieve all shifts
    $staffDetails = Shift::all();
    $salesDetails= Sale::all();
    $departments = Department::all();
    
    // Return the view with all shifts data
    return view('pages.sales.editsale', compact('staffDetails','salesDetails','departments'));
}

// to test =================================

protected function storeShift(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required' ,
        ]);
        // Parse the dates
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        // Create the Shift model instance with specific fields
        $shift = new Shift();
        $shift->shop_id = $request->input('shop_id');
        $shift->staff_id = $request->input('staff_id');
        $shift->start_date = $startDate; // Adjusted to use start_date
        $shift->end_date = $endDate; // Adjusted to use end_date
        $shift->start_time = $request->input('start_time');
        $shift->end_time = $request->input('end_time');
        $shift->save();

        // Return the ID of the newly created shift
        return $shift->id;
    }

    protected function getLastShiftId()
    {
        // Retrieve the last inserted shift's ID
        $lastShift = Shift::latest()->first();
        return $lastShift->id;
    }

    public function store(Request $request)
    {
        // Validate the incoming sales data
        $request->validate([
            'dept_id' => 'required|array', // Ensure dept_id is an array
            'dept_id.*' => 'required|numeric', // Validate each department ID
            'amount' => 'required|array', // Ensure amount is an array
            'amount.*' => 'required|numeric', // Validate each amount
        ]);

        try {
            // Initialize an associative array to keep track of total amount for each department
            $departmentTotals = [];

            // Loop through each department ID and amount to create or update sales records
            foreach ($request->dept_id as $key => $deptId) {
                // If department ID already exists in the associative array, add the amount
                if (isset($departmentTotals[$deptId])) {
                    $departmentTotals[$deptId] += $request->amount[$key];
                } else {
                    // If department ID is new, set the initial amount
                    $departmentTotals[$deptId] = $request->amount[$key];
                }
            }

            // Loop through the associative array to create or update sales records
            foreach ($departmentTotals as $deptId => $totalAmount) {
                // Find existing sale record for the department ID and shift ID
                $sale = Sale::where('dept_id', $deptId)
                    ->where('shift_id', $this->getLastShiftId())
                    ->first();

                if ($sale) {
                    // If sale record exists, update the amount
                    $sale->amount += $totalAmount;
                    $sale->save();
                } else {
                    // If no sale record exists, create a new one
                    Sale::create([
                        'dept_id' => $deptId,
                        'amount' => $totalAmount,
                        'shift_id' => $this->getLastShiftId(),
                    ]);
                }
            }

            // Redirect back with success message
            return "Sales Registered Successfully!";
        } catch (\Exception $e) {
            // Handle any errors that occur during the process
            return "Sales Registered Error!";
        }
    }


    

        public function index()
        {
        // Fetch all shifts from the database
            $shops = Shop::all();
            $staffs = Staff::all();
            $shifts = Shift::all();
            $departments = Department::all();
            $paymentmethods = Paymentmethod::all(); 
            $paymentSales = PaymentSale::all();
            $pettyCashReasons = PettyCashReason::all();
            return view('pages.sales.create', compact('shops', 'staffs','shifts','departments','paymentmethods','paymentSales','pettyCashReasons'));
        }

        

        public function searchShiftStaff()
    {
        $staffUsernames = Staff::pluck('username')->toArray();
        return view('pages.reports.shiftStaff', compact('staffUsernames'));
    }

    public function displayShifts(Request $request)
    {
        $username = $request->input('username');

        // Find staff member by username
        $staff = Staff::where('username', $username)->first();

        if (!$staff) {
            return redirect()->route('search.shift.staff')->with('error', 'Staff not found');
        }

        // Retrieve shifts related to the staff member
        $shifts = Shift::where('staff_id', $staff->id)->get();

        // Retrieve all staff usernames for the dropdown
        $staffUsernames = Staff::pluck('username')->toArray();

        return view('pages.reports.shiftStaff', compact('staff', 'shifts', 'staffUsernames'));
    }



    public function show()
    {
    // Fetch all shifts from the database
        $shops = Shop::all();
        $staffs = Staff::all();
        $shifts = Shift::all();
        $departments = Department::all();
        $paymentmethods = Paymentmethod::all(); 
        $paymentSales = PaymentSale::all();
        $pettyCashReasons = PettyCashReason::all();
        return view('pages.sales.manage_sales.allShifts', compact('shops', 'staffs','shifts','departments','paymentmethods','paymentSales','pettyCashReasons'));
    }

    public function edit($shiftId)
    {
        $shift = Shift::findOrFail($shiftId);
        return response()->json($shift);
    }    

    public function shift_update(Request $request, $shiftId)
    {
        // Validate the request data
        $request->validate([
            'shop_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $startDate = Carbon::parse($request->input('start_date'));
                    $endDate = Carbon::parse($request->input('end_date'));
                    $startTime = Carbon::parse($request->input('start_time'));
                    $endTime = Carbon::parse($value);

                    if ($startDate->eq($endDate) && $endTime->lte($startTime)) {
                        $fail('The end time must be after the start time when the start and end dates are the same.');
                    }
                },
            ],
        ]);

        // Parse the start and end dates
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));

        // Find the existing Shift model instance
        $shift = Shift::findOrFail($shiftId);
        $shift->shop_id = $request->input('shop_id');
        $shift->staff_id = $request->input('staff_id');
        $shift->start_date = $startDate; // Assign the parsed start date directly
        $shift->end_date = $endDate; // Assign the parsed end date directly
        $shift->start_time = $request->input('start_time');
        $shift->end_time = $request->input('end_time');
        $shift->save();

        // Return success message or redirect
        return redirect()->back()->with('success', 'Shift updated successfully!');
    }    

    // public function manageSales($shiftId)
    // {
    //     $shift = Shift::findOrFail($shiftId);

    //     // Retrieve records related to the shift
    //     $sales = Sale::where('shift_id', $shiftId)->get();
    //     $paymentSales = Paymentsale::where('shift_id', $shiftId)->get();
    //     $petticashes = Petticash::where('shift_id', $shiftId)->get();
    //     $cashDiffers = Cashdiffer::where('shift_id', $shiftId)->get();
    //     $departments = Department::all(); // Retrieve all departments
    //     $paymentMethods = Paymentmethod::all(); // Retrieve all payment methods
    //     $pettyCashReasons = Pettycashreason::all(); // Retrieve all petty cash reasons

    //     // Pass the data to the view
    //     return view('pages.sales.manage_sales.manageSales', compact('shift', 'sales', 'paymentSales', 'petticashes', 'cashDiffers', 'departments', 'paymentMethods', 'pettyCashReasons'));
    // }

    public function manageSales($shiftId)
    {
        $shift = Shift::findOrFail($shiftId);

        // Retrieve records related to the shift
        $sales = Sale::where('shift_id', $shiftId)->get();
        $paymentSales = Paymentsale::where('shift_id', $shiftId)->get();
        $petticashes = Petticash::where('shift_id', $shiftId)->get();
        $cashDiffers = Cashdiffer::where('shift_id', $shiftId)->get();
        $departments = Department::all(); // Retrieve all departments
        $paymentMethods = Paymentmethod::all(); // Retrieve all payment methods
        $pettyCashReasons = Pettycashreason::all(); // Retrieve all petty cash reasons

        // Use the total amount from the Shift table
        $totalAmount = $shift->total_amount;

        // Pass the data to the view
        return view('pages.sales.manage_sales.manageSales', compact('shift', 'sales', 'paymentSales', 'petticashes', 'cashDiffers', 'departments', 'paymentMethods', 'pettyCashReasons', 'totalAmount'));
    }



    public function sales_edit($id)
    {
        $sales = Sale::findOrFail($id);
        return response()->json($sales);
    }    

    public function sales_update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $shiftId = $sale->shift_id; // Get the shift ID from the sale

        // Validate incoming request data
        $request->validate([
            'dept_id' => 'required|exists:departments,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $newDeptId = $request->input('dept_id');
        $newAmount = $request->input('amount');

        // Check if a sale for the same department already exists in the same shift
        $existingSale = Sale::where('shift_id', $shiftId)
                            ->where('dept_id', $newDeptId)
                            ->where('id', '!=', $id)
                            ->first();

        if ($existingSale) {
            // Combine the amounts if an existing sale is found
            $existingSale->amount += $newAmount;
            $existingSale->save();

            // Delete the original sale
            $sale->delete();
        } else {
            // Update the sale record if no existing sale is found
            $sale->update([
                'dept_id' => $newDeptId,
                'amount' => $newAmount,
            ]);
        }

        // Redirect to the manage sales page with the shift ID
        return redirect()->route('shifts.manageSales', ['shiftId' => $shiftId])->with('success', 'Sale updated successfully!');
    }


    public function sales_destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->back()->with('success', 'Sale deleted successfully!');
    } 



    
    // Edit Payment Sale
    public function paymentSales_edit($paymentSaleId)
    {
        $paymentSale = Paymentsale::findOrFail($paymentSaleId);
        return response()->json($paymentSale);
    }

    public function paymentSales_update(Request $request, $paymentSaleId)
    {
        $paymentSale = Paymentsale::findOrFail($paymentSaleId);

        $request->validate([
            'paymentmethod_id' => 'required|exists:paymentmethods,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $paymentSale->update($request->only('paymentmethod_id', 'amount'));

        return redirect()->route('shifts.manageSales', ['shiftId' => $paymentSale->shift_id])
            ->with('success', 'Payment sale updated successfully!');
    }

    public function petticash_edit($petticashId)
    {
        $petticash = Petticash::findOrFail($petticashId);
        return response()->json($petticash);
    }

    public function petticash_update(Request $request, $petticashId)
    {
        $petticash = Petticash::findOrFail($petticashId);

        $request->validate([
            'petty_cash_reason_id' => 'required|exists:petty_cash_reasons,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $petticash->update($request->only('petty_cash_reason_id', 'amount'));

        return redirect()->route('shifts.manageSales', ['shiftId' => $petticash->shift_id])
            ->with('success', 'Petticash updated successfully!');
    }

    public function cashdiffers_edit($cashdifferId)
    {
        $cashdiffer = Cashdiffer::findOrFail($cashdifferId);
        return response()->json($cashdiffer);
    }

    public function cashdiffers_update(Request $request, $cashdifferId)
    {
        $cashdiffer = Cashdiffer::findOrFail($cashdifferId);

        $request->validate([
            'cashdifference' => 'required|numeric',
        ]);

        $cashdiffer->update($request->only('cashdifference'));

        return redirect()->route('shifts.manageSales', ['shiftId' => $cashdiffer->shift_id])
            ->with('success', 'Cash difference updated successfully!');
    }


    public function paymentSales_destroy($id)
    {
        $paymentSale = Paymentsale::findOrFail($id);
        $paymentSale->delete();
        return redirect()->back()->with('success', 'Payment sale deleted successfully!');
    }

    public function petticash_destroy($id)
    {
        $petticash = Petticash::findOrFail($id);
        $petticash->delete();
        return redirect()->back()->with('success', 'Petticash deleted successfully!');
    }

    public function cashdiffers_destroy($id)
    {
        $cashdiffer = Cashdiffer::findOrFail($id);
        $cashdiffer->delete();
        return redirect()->back()->with('success', 'Cash difference deleted successfully!');
    }


    // ADD SHIFT FROM ADMING =============================================================================
    public function addSale(Request $request, $shiftId)
    {
        // Validate the request data
        $request->validate([
            'dept_id' => 'required|exists:departments,id',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            // Retrieve the shift
            $shift = Shift::findOrFail($shiftId);

            // Create a new sale record
            Sale::create([
                'shift_id' => $shiftId,
                'dept_id' => $request->input('dept_id'),
                'amount' => $request->input('amount'),
            ]);

            // Update the total amount in the shift record
            $shift->total_amount += $request->input('amount');
            $shift->save();

            // Redirect back with a success message
            return redirect()->route('shifts.manageSales', ['shiftId' => $shiftId])
                            ->with('success', 'Sale added successfully, and total amount updated!');
        } catch (\Exception $e) {
            // Log the error and return an error message
            \Log::error('Error adding sale: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to add sale. Please try again.');
        }
    }


}