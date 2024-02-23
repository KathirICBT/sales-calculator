<?php

namespace App\Http\Controllers;
use App\Models\Staff; 

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        // Fetch staff from the database
        $staffs = Staff::all();

        // Pass the staff variable to the view
        return view('staff.index', compact('staffs'));
    }

    public function showRegistrationForm()
    {
        return view('staff.addstaff');
    }

    public function addstaff(Request $request)
    {
        $validatedData = $request->validate([
            'staff_name' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:20',
        ]);

        Staff::create([
            'staff_name' => $validatedData['staff_name'],
            'phonenumber' => $validatedData['phonenumber'],
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff registered successfully!');
    }

    public function edit(Staff $staff)
{
    return view('staff.update', compact('staff'));
}

public function update(Request $request, Staff $staff)
{
    $request->validate([
        'staff_name' => 'required|string|max:255',
        'phonenumber' => 'required|string|max:20',
    ]);

    $staff->update([
        'staff_name' => $request->input( 'staff_name'),
        'phonenumber' => $request->input('phonenumber'),
        // Add more fields if necessary
    ]);

    return redirect('/staff')->with('success', 'Staff member updated successfully!');
}
public function destroy(Staff $staff)
{
    $staff->delete();
    return redirect()->route('staff.index')->with('success', 'Staff member deleted successfully!');
}


public function search(Request $request)
{
    $search = $request->input('search');

    // Perform the search query
    $staff = Staff::where('staff_name', 'LIKE', "%$search%")
                  ->orWhere('phonenumber', 'LIKE', "%$search%")
                  ->get();

    return view('staff.search', compact('staff'));
}

}
