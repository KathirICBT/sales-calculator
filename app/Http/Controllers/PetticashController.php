<?php

namespace App\Http\Controllers;
use App\Models\Petticash;
use App\Models\Shift;


use Illuminate\Http\Request;

class PetticashController extends Controller
{
    public function create()
    {
        $shifts = Shift::all();
        return view('petticash.create', compact('shifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shift_id' => 'required',
            'reason' => 'required',
            'amount' => 'required',
        ]);

        Petticash::create($request->all());

        return redirect()->route('petticash.create')->with('success', 'Petticash entry added successfully!');
    }
}
