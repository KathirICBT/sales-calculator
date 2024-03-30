<?php

namespace App\Http\Controllers;
use App\Models\Cashdiffer;
use App\Models\Shift;

use Illuminate\Http\Request;

class CashdifferController extends Controller
{
    // public function create()
    // {
    //     return view('cashdiffer.create');
    // }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'cashdifference' => 'required|numeric',
        ]);
    
        // Fetch the last shift ID
        $lastShiftId = $this->getLastShiftId();
    
        // Create a new Cashdiffer instance and populate it with the validated data
        Cashdiffer::create([
            'shift_id' => $lastShiftId,
            'cashdifference' => $request->cashdifference,
        ]);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Cash difference added successfully!');
    }
    protected function getLastShiftId()
    {
        // Retrieve the last submitted shift's ID
        $lastShift = Shift::latest()->first();
        return $lastShift->id ?? null;
    }
}
