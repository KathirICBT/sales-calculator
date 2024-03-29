<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Shop;
use App\Models\Staff;
use Carbon\Carbon;

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
        $request->validate([
            'shop_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
        ]);

        Shift::create($request->all());

        return redirect()->route('shifts.create')->with('success', 'Shift added successfully!');
    }

    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        $shops = Shop::all();
        $staffs = Staff::all();
        return view('shifts.edit', compact('shift', 'shops', 'staffs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'shop_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
        ]);

        $shift = Shift::findOrFail($id);
        $shift->update($request->all());

        return redirect()->route('shifts.index')->with('success', 'Shift updated successfully!');
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

}
