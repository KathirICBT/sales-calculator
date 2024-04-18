<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
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
        
        

        // ADD FIRST TWO PAYMENT TYPE ===================================================================================

        // Check if "Bank" and "Cash" exist in the database
        $existingPaymentTypes = PaymentType::whereIn('payment_type', ['Bank', 'Cash'])->pluck('payment_type')->toArray();
        
        // If any of them don't exist, add them
        if (!in_array('Bank', $existingPaymentTypes)) {
            PaymentType::create(['payment_type' => 'Bank']);
        }
        if (!in_array('Cash', $existingPaymentTypes)) {
            PaymentType::create(['payment_type' => 'Cash']);
        }

        // =============================================================================================================




        $paymentTypes = PaymentType::all();
        return view('pages.income.payment_types.create', compact('paymentTypes'));
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


    // public function destroy($id)
    // {
    //     $paymentType = PaymentType::findOrFail($id);
    //     $paymentType->delete();

    //     return redirect()->route('paymenttype.store')->with('success', 'Payment type deleted successfully!');
    // }


    public function destroy($id)
    {
        try {
            $paymentType = PaymentType::findOrFail($id);
            $paymentType->delete();

            // Redirect with success message
            return redirect()->route('paymenttype.store')->with('success', 'Payment type deleted successfully!');
        } catch (QueryException $e) {
            // Check if the error is due to a foreign key constraint violation
            if ($e->errorInfo[1] === 1451) {
                // Redirect with error message for foreign key constraint violation
                return redirect()->route('paymenttype.store')->with('error', 'Cannot delete Payment Type. It is referenced by other records.');
            }

            // If it's another type of error, log it for debugging purposes
            Log::error('Error deleting Payment Type: ' . $e->getMessage());

            // Redirect with generic error message
            return redirect()->route('paymenttype.store')->with('error', 'An error occurred while deleting the Payment Type.');
        }
    }

}
