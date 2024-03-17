<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


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


    // public function resetPassword(Request $request)
    // {      
    //     //dd($request);  
    //     //dump($request->all());
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'username' => 'required',
    //         'newPassword' => 'required|string|min:8|confirmed',
    //     ]);
        
    //     // dump($validatedData);
    //     // dd($validatedData);
    
    //     // Find the staff member by username
    //     $staff = Staff::where('username', $validatedData['username'])->first();

        
    
    //     if (!$staff) {
    //         // Handle case where staff member is not found
    //         return redirect()->back()->withErrors(['username' => 'Staff member not found']);
    //     }
    
    //     // Update the staff member's password
    //     $staff->password = Hash::make($validatedData['newPassword']);
        
    //     try {
    //         $staff->save();
    //         // Redirect back with success message
    //         return redirect()->back()->with('success', 'Password reset successfully');
    //     } catch (\Exception $e) {
    //         // Handle database save error
    //         return redirect()->back()->with('error', 'Failed to reset password. Please try again.');
    //     }
    // }


public function resetPassword(Request $request)
{      
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'username' => 'required',
        'newPassword' => 'required|string|min:5|confirmed',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Find the staff member by username
    $staff = Staff::where('username', $request->username)->first();

    if (!$staff) {
        // Handle case where staff member is not found
        return redirect()->back()->withErrors(['username' => 'Staff member not found']);
    }

    // Update the staff member's password
    $staff->password = Hash::make($request->newPassword);
    
    try {
        $staff->save();
        // Redirect back with success message
        return redirect()->back()->with('success', 'Password reset successfully');
    } catch (\Exception $e) {
        // Handle database save error
        return redirect()->back()->with('error', 'Failed to reset password. Please try again.');
    }
}

    

// public function showProfile()
// {
//     // Retrieve the authenticated user's staff information
//     $staff = Auth::user();
//     // Pass the staff information to the view
//     return view('auth.profile.profile', compact('staff'));
// }

public function showProfile()
{
    // Check if the user is logged in
    if (Auth::guard('staff')->check()) {
        // Get the authenticated staff user
        $staff = Auth::guard('staff')->user();
        
        // Return the staff details
        return view('auth.profile.profile')->with('staff', $staff);
   
}
}
    
}
