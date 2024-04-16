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
        if ($request->isMethod('post')) {
        // Validate the request data
            $validatedData = $request->validate([
                'payment_method' => 'required|string',
            ]);

            // Create a new payment method
            Paymentmethod::create($validatedData);

            // Redirect back with success message
            return redirect()->route('paymentmethod.store')->with('success', 'Payment method added successfully!');
        }
        $paymentMethods = Paymentmethod::all(); 
        return view('pages.sales.paymentmethod.create', ['paymentMethods' => $paymentMethods]); 

    }

    // public function edit(Paymentmethod $paymentMethod)
    // {
    //     return response()->json($paymentMethod);
    // }
    

    // public function update(Request $request, Paymentmethod $paymentMethod)
    // {
    //      $request->validate([
    //         'payment_method' => 'required|string',
    //     ]);

    //     $updated = $paymentMethod->update([
    //         'payment_method' => $request->input('payment_method'),
            
    //     ]);

    //     if ($updated !== false) {             
    //         return redirect()->route('paymentmethod.store')->with('success', 'Department updated successfully!');
    //     } else {            
    //         return redirect()->route('paymentmethod.store')->with('error', 'Failed to update department!');
    //     }

        
    // }
    public function edit($paymentMethodId)
    {
        // Retrieve the payment method by its ID
        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);
        
        // Return the payment method data as JSON
        return response()->json($paymentMethod);
    }

    public function update(Request $request, $paymentMethodId)
    {
        // Validate the form data
        $request->validate([
            'payment_method' => 'required|string|max:255',
        ]);

        // Find the payment method by its ID
        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);
        
        // Update the payment method with the submitted data
        $paymentMethod->update([
            'payment_method' => $request->input('payment_method'),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Payment method updated successfully.');
    }
    

    public function destroy($id)
    {
        $paymentMethod = Paymentmethod::findOrFail($id);
        $paymentMethod->delete();

        return redirect()->route('paymentmethod.store')->with('success', 'Payment method deleted successfully!');
    }
}
