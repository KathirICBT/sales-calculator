<?php

namespace App\Http\Controllers;


use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::all();
        return view('staff.index', compact('staffs'));
    }

    public function showRegistrationForm()
    {
        return view('pages.staff.addstaff');
    }

    // public function addstaff(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'staff_name' => 'required|string|max:255',
    //         'username' => 'required|string|unique:staffs',
    //         'password' => 'required|string',
    //         'phonenumber' => 'required|string|max:20',
    //     ]);
    
    //     Staff::create([
    //         'staff_name' => $validatedData['staff_name'],
    //         'username' => $validatedData['username'],
    //         'password' => Hash::make($validatedData['password']),
    //         'phonenumber' => $validatedData['phonenumber'],
    //     ]);
    
    //     return redirect()->route('staff.addstaff')->with('success', 'Staff registered successfully!');
    // }

    //NEW ADD STAFF METHOD =================================================

    // public function addstaff(Request $request)
    // {
    //     // Check if the request contains form data for adding a staff member
    //     if ($request->isMethod('post')) {
    //         // Validate the request data
    //         $validatedData = $request->validate([
    //             'staff_name' => 'required|string|max:255',
    //             'username' => 'required|string|unique:staffs',
    //             'password' => 'required|string',
    //             'phonenumber' => 'required|string|max:20',
    //         ]);

    //         // Create a new staff member
    //         Staff::create([
    //             'staff_name' => $validatedData['staff_name'],
    //             'username' => $validatedData['username'],
    //             'password' => Hash::make($validatedData['password']),
    //             'phonenumber' => $validatedData['phonenumber'],
    //         ]);

    //         // Redirect back to the index page with a success message
    //         return redirect()->route('staff.addstaff')->with('success', 'Staff registered successfully!');
    //     }

    //     // If the request is not a POST request, retrieve all staff members
    //     $staffs = Staff::all();

    //     // Display the index view with the staff members
    //     return view('pages.staff.addstaff', compact('staffs'));
    // }

    public function addstaff(Request $request)
    {
        // Check if the request contains form data for adding a staff member
        if ($request->isMethod('post')) {
            // Validate the request data
            $validatedData = $request->validate([
                'staff_name' => 'required|string|max:255',
                'username' => 'required|string|unique:staffs',
                'password' => 'required|string',
                'phonenumber' => 'required|string|max:20',
            ]);

            // Create a new staff member
            Staff::create([
                'staff_name' => $validatedData['staff_name'],
                'username' => $validatedData['username'],
                'password' => Hash::make($validatedData['password']),
                'phonenumber' => $validatedData['phonenumber'],
            ]);

            // Redirect back to the index page with a success message
            return redirect()->route('staff.addstaff')->with('success', 'Staff registered successfully!');
        }

        // If the request is not a POST request, retrieve all staff members
        $staffCount = Staff::count(); // Count the number of staff members
        $staffs = Staff::all();

        // Display the index view with the staff members
        return view('pages.staff.addstaff', compact('staffs', 'staffCount'));
    }


    //======================================================================
    

    public function edit(Staff $staff)
    {
        //return view('pages.staff.addstaff', compact('staff'));
        return response()->json($staff);
    }

    // public function update(Request $request, Staff $staff)
    // {
    //     $validatedData = $request->validate([
    //         'staff_name' => 'required|string|max:255',
    //         'phonenumber' => 'required|string|max:20',
    //         'username' => 'required|string|unique:staffs,username,' . $staff->id,            
    //     ]);        

    //     $staff->update($validatedData);

    //     return redirect()->route('staff.addstaff')->with('success', 'Staff member updated successfully!');
    // }

    public function update(Request $request, Staff $staff)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'staff_name' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:20',
            // 'username' => 'required|string|unique:staffs,username,' . $staff->id,                      
        ]);  

        // Dump the request data and validated data for debugging
        //dd($request->all(), $validatedData);
        //dd($staff->id);

        // Update the staff member's information
        $updated = $staff->update($validatedData);

        // Check if the update operation was successful
        if ($updated) {
            // Redirect back with success message
            return redirect()->route('staff.addstaff')->with('success', 'Staff member updated successfully!');
        } else {
            // Redirect back with error message
            return redirect()->route('staff.addstaff')->with('error', 'Failed to update staff member!');
        }
    }
    


    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.addstaff')->with('success', 'Staff member deleted successfully!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $staff = Staff::where('staff_name', 'LIKE', "%$search%")
                      ->orWhere('phonenumber', 'LIKE', "%$search%")
                      ->orWhere('username', 'LIKE', "%$search%")
                      ->get();

        return view('staff.search', compact('staff'));
    }
}
