<?php

namespace App\Http\Controllers;
use App\Models\PaymentType;

use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function index()
    {
        $paymentTypes = PaymentType::all();
        return view('payment_types.index', compact('paymentTypes'));
    }

    public function create()
    {
        return view('payment_types.create');
    }

    // public function store(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $validatedData = $request->validate([
    //             'payment_type' => 'required|string|max:255',
    //         ]);

    //         PaymentType::create($validatedData);

    //         return redirect()->route('paymenttype.store')->with('success', 'Payment type added successfully!');
    //     }
    //     $paymentTypes = PaymentType::all();
    //     return view('pages.payment_types.create', compact('paymentTypes'));
    
    // }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {            
            $validatedData = $request->validate([
                'payment_type' => 'required|string|max:255|unique:payment_types',
            ], [
                'payment_type.unique' => 'The payment type has already been added.',
            ]);            
            PaymentType::create($validatedData);            
            return redirect()->route('paymenttype.store')->with('success', 'Payment type added successfully!');
        }        
        $paymentTypes = PaymentType::all();
        return view('pages.owner.payment_types.create', compact('paymentTypes'));
    }


    public function edit($id)
    {
        $paymentType = PaymentType::findOrFail($id);
        return response()->json($paymentType);
    }

    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'payment_type' => 'required|string|max:255',
    //     ]);
    //     $paymentType = PaymentType::findOrFail($id);
    //     $paymentType->update($validatedData);
    //     return redirect()->back()->with('success', 'Payment type updated successfully.');
    // }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'payment_type' => 'required|string|max:255|unique:payment_types,payment_type,' . $id,            
        ], [
            'payment_type.unique' => 'The payment type has already been added.',
        ]);

        $paymentType = PaymentType::findOrFail($id);
        $paymentType->update($validatedData);

        return redirect()->back()->with('success', 'Payment type updated successfully.');
    }


    public function destroy($id)
    {
        $paymentType = PaymentType::findOrFail($id);
        $paymentType->delete();

        return redirect()->route('paymenttype.store')->with('success', 'Payment type deleted successfully!');
    }
}
