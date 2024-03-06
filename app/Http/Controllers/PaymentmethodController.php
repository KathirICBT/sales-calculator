<?php

namespace App\Http\Controllers;
use App\Models\Paymentmethod;


use Illuminate\Http\Request;

class PaymentmethodController extends Controller
{
    public function index()
    {
        $paymentMethods = Paymentmethod::all(); 
        return view('paymentmethods.index', ['paymentMethods' => $paymentMethods]); 
    }

    public function create()
    {
        return view('paymentmethods.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'payment_method' => 'required|string',
        ]);

        // Create a new payment method
        Paymentmethod::create($validatedData);

        // Redirect back with success message
        return redirect()->route('paymentmethod.create')->with('success', 'Payment method added successfully!');
    }

    public function edit($id)
    {
        $paymentMethod = Paymentmethod::findOrFail($id);
        return view('paymentmethods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|string',
        ]);

        $paymentMethod = Paymentmethod::findOrFail($id);
        $paymentMethod->update($validatedData);

        return redirect()->route('paymentmethod.create')->with('success', 'Payment method updated successfully!');
    }

    public function destroy($id)
    {
        $paymentMethod = Paymentmethod::findOrFail($id);
        $paymentMethod->delete();

        return redirect()->route('paymentmethod.create')->with('success', 'Payment method deleted successfully!');
    }
}
