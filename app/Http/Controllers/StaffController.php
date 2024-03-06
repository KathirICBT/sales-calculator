<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
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
        return view('staff.addstaff');
    }

    public function addstaff(Request $request)
    {
        $validatedData = $request->validate([
            'staff_name' => 'required|string|max:255',
            'username' => 'required|string|unique:staffs',
            'password' => 'required|string',
            'phonenumber' => 'required|string|max:20',
        ]);
    
        Staff::create([
            'staff_name' => $validatedData['staff_name'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
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
        $validatedData = $request->validate([
            'staff_name' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:20',
            'username' => 'required|string|unique:staffs,username,' . $staff->id,
            'password' => 'nullable|string',
        ]);

        if ($request->has('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']); // Hash the password
        }

        $staff->update($validatedData);

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

        $staff = Staff::where('staff_name', 'LIKE', "%$search%")
                      ->orWhere('phonenumber', 'LIKE', "%$search%")
                      ->orWhere('username', 'LIKE', "%$search%")
                      ->get();

        return view('staff.search', compact('staff'));
    }
}
