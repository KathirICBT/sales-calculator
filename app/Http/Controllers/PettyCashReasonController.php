<?php

namespace App\Http\Controllers;
use App\Models\PettyCashReason;

use Illuminate\Http\Request;

class PettyCashReasonController extends Controller
{
    public function index()
    {
       //
    }

    public function store(Request $request)
    {       
         if ($request->isMethod('post')) {
            // dd($request->all());
            // Validate the request data
            $validatedData = $request->validate([
                'petty_cash_reason' => 'required|string',
            ]);

            // Create a new PettyCashReason instance
            $pettyCashReason = new PettyCashReason();
            $pettyCashReason->reason = $validatedData['petty_cash_reason'];

            // Save the new petty cash reason
            $pettyCashReason->save();            

            // Redirect back with success message
            return redirect()->route('pettycashreason.store')->with('success', 'Payment method added successfully!');
         }
        $pettyCashReason = PettyCashReason::all(); 
        return view('pages.pettyCashReason.create', ['pettyCashReason' => $pettyCashReason]); 

    }
}
