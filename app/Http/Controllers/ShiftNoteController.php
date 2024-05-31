<?php

namespace App\Http\Controllers;

use App\Models\ShiftNote;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use App\Models\Staff;
use App\Models\Shift;

class ShiftNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
// public function index()
// {
//     // Retrieve the current username from the session
//     $username = Session::get('username') ?? Session::get('adminusername');

//     // Find the staff record based on the username
//     $staff = Staff::where('username', $username)->first();

//     // Check if the staff exists
//     if ($staff) {
//         $shopId = $staff->shop_id;

//         // Find the last shift for the current staff and their shop
//         $lastShift = Shift::where('staff_id', $staff->id)
//                           ->where('shop_id', $shopId)
//                           ->latest()
//                           ->first();

//         // Check if a shift exists
//         if ($lastShift) {
//             $shiftId = $lastShift->id;
//         } else {
//             $shiftId = null; // Handle the case where there is no shift
//         }
//     } else {
//         // Handle the case where the staff is not found
//         return redirect()->route('login');
//     }

//     // Pass the shop_id, username, and shift_id to the view
//     return view('pages.sales.shiftNote', [
//         'shop_id' => $shopId,
//         'username' => $username,
//         'shift_id' => $shiftId
//     ]);
// }

public function index()
{
    // Retrieve the current username or adminusername from the session
    $username = Session::get('username') ?? Session::get('adminusername');

    // Find the staff record based on the username
    $staff = Staff::where('username', $username)->first();

    // Check if the staff exists
    if ($staff) {
        $shopId = $staff->shop_id;

        // Find the last shift for the current staff
        $lastShift = Shift::where('staff_id', $staff->id)
                          ->latest()
                          ->first();

        // Check if a shift exists
        if ($lastShift) {
            $shiftId = $lastShift->id;
        } else {
            $shiftId = null; // Handle the case where there is no shift
        }
    } else {
        // Handle the case where the staff is not found
        return redirect()->route('login');
    }

    // Pass the shop_id, username, and shift_id to the view
    return view('pages.sales.shiftNote', [
        'shop_id' => $shopId,
        'username' => $username,
        'shift_id' => $shiftId
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'shift_note' => 'required|string',
    //         'shift_id' => 'required|exists:shifts,id',
    //     ]);

    //     // Create a new ShiftNote instance and save it to the database
    //     ShiftNote::create([
    //         'note' => $request->input('shift_note'),
    //         'shift_id' => $request->input('shift_id'),
    //     ]);

    //     // Redirect back or to another page with a success message
    //     return redirect()->route('shifts.index')->with('success', 'Shift note added successfully.');
    // }

    public function store(Request $request)
{
    // Validate the incoming request with custom error messages
    $request->validate([
        'shift_note' => 'required|string',
        'shift_id' => 'required|exists:shifts,id',
    ], [
        'shift_id.required' => 'There is no shift for this user.',        
    ]);

    // Create a new ShiftNote instance and save it to the database
    ShiftNote::create([
        'note' => $request->input('shift_note'),
        'shift_id' => $request->input('shift_id'),
    ]);

    // Redirect back or to another page with a success message
    return redirect()->route('shifts.index')->with('success', 'Shift note added successfully.');
}


    /**
     * Display the specified resource.
     */
    // public function show(ShiftNote $shiftNote)
    // {
    //     //
    // }

    public function show()
    {
        // Fetch all ShiftNote instances with their associated Shift instances, along with staff and shop details
        $shiftNotes = ShiftNote::with('shift.staff', 'shift.shop')->get();

        // Pass the $shiftNotes to the view
        return view('pages.sales.showShiftNote', ['shiftNotes' => $shiftNotes]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShiftNote $shiftNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShiftNote $shiftNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShiftNote $shiftNote)
    {
        //
    }
}
