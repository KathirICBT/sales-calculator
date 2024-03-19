<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Shop;
use App\Models\Staff;
use Carbon\Carbon;

use App\Models\Sale; // Import Sale model
use App\Models\Department;
use Illuminate\Support\Facades\DB; 


class ShiftController extends Controller
{
    public function index()
    {
        // Fetch all shifts from the database
        $shifts = Shift::all();
        return view('shifts.index', compact('shifts'));
    }

    public function create()
    {
        // Fetch shops and staffs to populate dropdown menus
        $shops = Shop::all();
        $staffs = Staff::all();
        return view('shifts.create', compact('shops', 'staffs'));
    }

    public function store(Request $request)
    {
       
        if ($request->isMethod('post')) {
            
            $request->validate([
                'shop_id' => 'required|numeric',
                'staff_id' => 'required|numeric',
                'date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);
            $date = Carbon::parse($request->input('date'));

    // Create the Shift model instance with specific fields
    $shift = new Shift();
    $shift->shop_id = $request->input('shop_id');
    $shift->staff_id = $request->input('staff_id');
    $shift->date = $date; // Assign the parsed date directly
    $shift->start_time = $request->input('start_time');
    $shift->end_time = $request->input('end_time');
    $shift->save();

            return redirect()->route('shifts.store')->with('success', 'Shift added successfully!');
        }
        $shops = Shop::all();
        $staffs = Staff::all();
        $shifts = Shift::all();
        $departments = Department::all();
        return view('pages.shift.create', compact('shops', 'staffs','shifts','departments'));
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
        'end_time' => 'required',
    ]);

    // Find the shift by ID
    $shift = Shift::findOrFail($id);

    // Update the shift details
    $shift->shop_id = $request->input('shop_id');
    $shift->date = $request->input('date');
    $shift->start_time = $request->input('start_time');
    $shift->end_time = $request->input('end_time');

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

        return view('shiftstaff.result', compact('staffDetails'));
    }

    public function directToSearch()
    {
        
        return view('shiftstaff.search');
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

    public function storeSales(Request $request)
{
    // Validate the request data
    $request->validate([
        'dept_id' => 'required|numeric',
        'shift_id' => 'required|numeric',
        'amount' => 'required|numeric',
    ]);

    // Check if a record with the same department and shift exists for today
    $existingSale = Sale::where('dept_id', $request->dept_id)
                        ->where('shift_id', $request->shift_id)
                        ->whereDate('created_at', now()->toDateString())
                        ->first();

    if ($existingSale) {
        // Update the existing sale record
        $existingSale->amount += $request->amount;
        $existingSale->save();
    } else {
        // Create a new sale record
        // Sale::create([
        //     'dept_id' => $request->dept_id,
        //     'shift_id' => $request->shift_id,
        //     'amount' => $request->amount,
        // ]);
        DB::table('sales')->insert([
            'dept_id' => $request->dept_id,
        'shift_id' => $request->shift_id,
        'amount' => $request->amount,
        'created_at' => now(),
        'updated_at' => now()
        ]);
    
    }

    // Redirect back with success message
    return redirect()->back()->with('success', 'Sales added successfully.');
}


}
