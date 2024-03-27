<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Shop;
use App\Models\Staff;
use Carbon\Carbon;
use App\Models\Paymentmethod;
use App\Models\Paymentsale;
use App\Models\Sale; // Import Sale model
use App\Models\Department;
use Illuminate\Support\Facades\DB; 


class ShiftController extends Controller
{
    // public function index()
    // {
    //     // Fetch all shifts from the database
    //     $shifts = Shift::all();
    //     return view('shifts.index', compact('shifts'));
    // }

    public function create()
    {
        // Fetch shops and staffs to populate dropdown menus
        $shops = Shop::all();
        $staffs = Staff::all();
        $paymentMethods = Paymentmethod::all(); 
        return view('shifts.create', compact('shops', 'staffs','paymentMethods'));
    }

    protected $currentShiftId;

//     public function storeShifts(Request $request)
// {
//     if ($request->isMethod('post')) {
        
<<<<<<< HEAD
//         $request->validate([
//             'shop_id' => 'required|numeric',
//             'staff_id' => 'required|numeric',
//             'start_date' => 'required|date',
//             'end_date' => 'required|date|after_or_equal:start_date',
//             'start_time' => 'required',
//             'end_time' => 'required',
//         ]);

//         // Parse the start and end dates
//         $startDate = Carbon::parse($request->input('start_date'));
//         $endDate = Carbon::parse($request->input('end_date'));
=======
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
>>>>>>> b5b7bb6a77fdb330f306cc337bda3b0fbb54014b

//         // Create the Shift model instance with specific fields
//         $shift = new Shift();
//         $shift->shop_id = $request->input('shop_id');
//         $shift->staff_id = $request->input('staff_id');
//         $shift->start_date = $startDate; // Assign the parsed start date directly
//         $shift->end_date = $endDate; // Assign the parsed end date directly
//         $shift->start_time = $request->input('start_time');
//         $shift->end_time = $request->input('end_time');
//         $shift->save();

//         $this->currentShiftId = $shift->id;
//         //return redirect()->route('shifts.index')->with('success', 'Shift added successfully!');
//         return "Shift Saved Successfully!";
//     }

//     $shops = Shop::all();
//     $staffs = Staff::all();
//     $shifts = Shift::all();
//     $departments = Department::all();
//     $paymentMethods = Paymentmethod::all(); 
//     return view('pages.sales.create', compact('shops', 'staffs','shifts','departments','paymentMethods'));
// }

public function storeShifts(Request $request)
    {
        // Get the currently authenticated user (staff)
        //$currentStaff = Auth::user();

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
            $shift->save();

            $this->currentShiftId = $shift->id;
            //return redirect()->route('shifts.index')->with('success', 'Shift added successfully!');
            return "Shift Saved Successfully!";
        }

        $shops = Shop::all();
        $staffs = Staff::all();
        $shifts = Shift::all();
        $departments = Department::all();
        $paymentMethods = Paymentmethod::all(); 
        return view('pages.sales.create', compact('shops', 'staffs','shifts','departments','paymentMethods'));
    }
    // public function edit($id)
    // {
    //     $shift = Shift::findOrFail($id);
    //     $shops = Shop::all();
    //     $staffs = Staff::all();
    //     return view('shifts.edit', compact('shift', 'shops', 'staffs'));
    // }
    
    public function edit(Shift $shift)
{
    // Return the shift details as JSON response
    return response()->json($shift);
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

        return redirect()->route('shifts.index')->with('success', 'Shift deleted successfully!');
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


    // public function storeSales(Request $request){
    
    //     if ($request->isMethod('post')) {
    //         $validatedData = $request->validate([
    //             'dept_id' => 'required|numeric',
    //             'shift_id' => 'required|numeric',
    //             'amount' => 'required|numeric',
    //         ]);

    //         // Check if a record with the same department, date, shop and staff exists
    //         $existingSale = Sale::where('dept_id', $validatedData['dept_id'])
    //                             ->where('shift_id', $validatedData['shift_id'])
    //                             ->whereDate('created_at', now()->toDateString())
    //                             ->first();

    //         if ($existingSale) {
    //             // Update the existing record
    //             $existingSale->amount += $validatedData['amount'];
    //             $existingSale->save();
    //         } else {
    //             // Create a new record
    //             Sale::create($validatedData);
    //         }
    //         // Redirect back with success message
    //         return redirect()->back()->with('success', 'Sales added successfully.');
    //     }
    //     $departments = Department::all();
    //     $shifts = Shift::all();
    //     return view('pages.shift.create', compact('departments', 'shifts'));
    // }

//     public function storeSales(Request $request)
// {
//     // Validate the request data
//     $request->validate([
//         'dept_id' => 'required|numeric',
//         'shift_id' => 'required|numeric',
//         'amount' => 'required|numeric',
//     ]);

//     // Check if a record with the same department and shift exists for today
//     $existingSale = Sale::where('dept_id', $request->dept_id)
//                         ->where('shift_id', $request->shift_id)
//                         ->whereDate('created_at', now()->toDateString())
//                         ->first();

//     if ($existingSale) {
//         // Update the existing sale record
//         $existingSale->amount += $request->amount;
//         $existingSale->save();
//     } else {
//         // Create a new sale record
//         // Sale::create([
//         //     'dept_id' => $request->dept_id,
//         //     'shift_id' => $request->shift_id,
//         //     'amount' => $request->amount,
//         // ]);
//         DB::table('sales')->insert([
//             'dept_id' => $request->dept_id,
//         'shift_id' => $request->shift_id,
//         'amount' => $request->amount,
//         'created_at' => now(),
//         'updated_at' => now()
//         ]);
    
//     }

//     // Redirect back with success message
//     return redirect()->back()->with('success', 'Sales added successfully.');
// }



// protected function storeShift(Request $request)
//     {
//         // Validate the incoming shift data
//         $request->validate([
//             'shop_id' => 'required|numeric',
//             'staff_id' => 'required|numeric',
//             'date' => 'required|date',
//             'start_time' => 'required',
//             'end_time' => 'required',
//         ]);

//         // Parse the date
//         $date = Carbon::parse($request->input('date'));

//         // Create the Shift model instance with specific fields
//         $shift = new Shift();
//         $shift->shop_id = $request->input('shop_id');
//         $shift->staff_id = $request->input('staff_id');
//         $shift->date = $date;
//         $shift->start_time = $request->input('start_time');
//         $shift->end_time = $request->input('end_time');
//         $shift->save();

//         // Return the ID of the newly created shift
//         return $shift->id;
//     }

//     protected function storeSales(Request $request, $shiftId)
//     {
//         var_dump($request);
//         dd($request);
//         // Validate the incoming sales data
//         $validatedData = $request->validate([
//             'dept_id.*' => 'required|numeric', // Validate each department ID
//             'amount.*' => 'required|numeric',  // Validate each amount
//         ]);

//         try {
//             // Loop through each department ID and amount to create or update sales records
//             foreach ($validatedData['dept_id'] as $key => $deptId) {
//                 // Find existing sale record for the department ID and shift ID
//                 $sale = Sale::where('dept_id', $deptId)
//                     ->where('shift_id', $shiftId)
//                     ->first();

//                 if ($sale) {
//                     // If sale record exists, update the amount
//                     $sale->amount += $validatedData['amount'][$key];
//                     $sale->save();
//                 } else {
//                     // If no sale record exists, create a new one
//                     Sale::create([
//                         'dept_id' => $deptId,
//                         'amount' => $validatedData['amount'][$key],
//                         'shift_id' => $shiftId,
//                     ]);
//                 }
//             }

//             // Redirect back with success message
//             return redirect()->back()->with('success', 'Sales data saved successfully!');
//         } catch (\Exception $e) {
//             // Handle any errors that occur during the process
//             return redirect()->back()->with('error', 'An error occurred while processing the request.');
//         }
//     }


//     public function store(Request $request)
//     {
//         if ($request->isMethod('post')){
//         // Check if the request is for storing a shift
//         if ($request->filled(['shop_id', 'staff_id', 'date', 'start_time', 'end_time'])) {
//             $shiftId = $this->storeShift($request);
//             // Call the storeSales method with the retrieved shift ID
//             return $this->storeSales($request, $shiftId);
//         }

//         // Handle other cases or invalid requests
//         return redirect()->back()->with('error', 'Invalid request.');
//     }
//         $shops = Shop::all();
//         $staffs = Staff::all();
//         $shifts = Shift::all();
//         $departments = Department::all();
//         return view('pages.sales.create', compact('shops', 'staffs','shifts','departments'));

//     }


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

//     protected function getLastShiftId()
// {
//     // Retrieve the last inserted shift's ID
//     $currentStaff = Auth::user();
//     $lastShift = Shift::where('staff_id', $currentStaff->id)->latest()->first();
//     return $lastShift ? $lastShift->id : null;
// }

    // public function getCurrentShiftId()
    // {
    //     // Access currentShiftId here
    //     if ($this->currentShiftId) {
    //         // Do something with $this->currentShiftId
    //         return $this->currentShiftId;
    //     } else {
    //         // Handle case when $this->currentShiftId is not set
    //         return 'Current shift ID not set.';
    //     }
    // }

    // public function store(Request $request)
    // {
    //     //dd($request->all());
    //     // Validate the incoming sales data
    //     $request->validate([
    //         'dept_id' => 'required|array', // Ensure dept_id is an array
    //         'dept_id.*' => 'required|numeric', // Validate each department ID
    //         'amount' => 'required|array', // Ensure amount is an array
    //         'amount.*' => 'required|numeric', // Validate each amount
    //     ]);

    //     try {
    //         // Loop through each department ID and amount to create or update sales records
    //         foreach ($request->dept_id as $key => $deptId) {
    //             // Find existing sale record for the department ID and shift ID
    //             $sale = Sale::where('dept_id', $deptId)
    //                 ->where('shift_id', $this->getLastShiftId())
    //                 ->first();

    //             if ($sale) {
    //                 // If sale record exists, update the amount
    //                 $sale->amount += $request->amount[$key];
    //                 $sale->save();
    //             } else {
    //                 // If no sale record exists, create a new one
    //                 Sale::create([
    //                     'dept_id' => $deptId,
    //                     'amount' => $request->amount[$key],
    //                     'shift_id' => $this->getLastShiftId(),
    //                 ]);
    //             }
    //         }
    //         // Redirect back with success message
    //         return "Sales Registed Successfully!";
    //         //return redirect()->route('shifts.index')->with('success', 'Shift added successfully!');
    //     } catch (\Exception $e) {
    //         // Handle any errors that occur during the process
    //         return "Sales Registed Error!";
    //         //return redirect()->route('shifts.index')->with('error', 'An error occurred while processing the request.');
    //     }
    // }

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
            return view('pages.sales.create', compact('shops', 'staffs','shifts','departments','paymentmethods','paymentSales'));
        }

        

      

}