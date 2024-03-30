<?php

namespace App\Http\Controllers;
use App\Models\Petticash;
use App\Models\Shift;


use Illuminate\Http\Request;

class PetticashController extends Controller
{
    // public function create()
    // {
    //     $shifts = Shift::all();
    //     return view('pages.sales.create', compact('shifts'));
    // }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            // 'shift_id' => 'required',
            'reason.*' => 'required|string',
            'petticash_amount.*' => 'required|numeric',
        ]);
        $lastShiftId = $this->getLastShiftId();

        // Petticash::create([
        //     'shift_id' => $lastShiftId,
        //     'amount' => $request->amount,
        //     'reason' => $request->reason,
        // ]);

        try {
            // Loop through each submitted entry
            foreach ($request->reason as $key => $reason) {
                // Create Petticash entry for each row
                //dd($request->petticash_amount[$key]);
                Petticash::create([
                    'shift_id' => $lastShiftId,
                    'reason' => $reason,
                    'amount' => $request->petticash_amount[$key],
                ]);
            }
    
            // Redirect back with success message
            return redirect()->back()->with('success', 'Petticash entries added successfully!');
        } catch (\Exception $e) {
            // Handle any errors that occur during the process
            return redirect()->back()->with('error', 'An error occurred while processing the request.');
        }
        
        // return redirect()->back()->with('success', 'Petticash entry added successfully!');
        // return redirect()->route('petticash.create')->with('success', 'Petticash entry added successfully!');
    }
    protected function getLastShiftId()
    {
        // Retrieve the last submitted shift's ID
        $lastShift = Shift::latest()->first();
        return $lastShift->id ?? null;
    }
}
