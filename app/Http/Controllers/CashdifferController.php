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

    
    public function edit($id)
    {
        $cashDiffer = Cashdiffer::findOrFail($id);
        return response()->json($cashDiffer);
    }

    // Update the specified cash differ in the database
    public function update(Request $request, $id)
    {
        $cashDiffer = Cashdiffer::findOrFail($id);

        // Validate incoming request data
        $request->validate([
            'cashdifference' => 'required|numeric|min:0',
        ]);

        // Update cash differ record
        $cashDiffer->update([
            'cashdifference' => $request->input('cashdifference'),
        ]);

        return redirect()->route('cashdiffers.index')->with('success', 'Cash difference updated successfully!');
    }

    // Delete the specified cash differ from the database
    public function destroy($id)
    {
        $cashDiffer = Cashdiffer::findOrFail($id);
        $cashDiffer->delete();

        return redirect()->route('cashdiffers.index')->with('success', 'Cash difference deleted successfully!');
    }

   
    public function index()
    {
        $cashdiffers = Cashdiffer::all();
        return view('pages.sales.cashDiffer', compact('cashdiffers'));
    }

}
