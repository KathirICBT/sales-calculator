<?php

namespace App\Http\Controllers;
use App\Models\Paymentsale;
use App\Models\Paymentmethod;
use Illuminate\Http\Request;

class PaymentsaleController extends Controller
{
    public function index()
    {
        $paymentSales = PaymentSale::all();
        return view('paymentsale.index', compact('paymentSales'));
    }

    public function create()
    {
        $paymentmethods=Paymentmethod::all();
    
        return view('paymentsale.create', compact('paymentmethods'));
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'paymentmethod_id' => 'required|exists:paymentmethods,id',
            'amount' => 'required|numeric',
        ]);


        Paymentsale::create($validatedData);
        
        
        return redirect()->route('paymentsale.create')->with('success', 'Paymentsale added successfully!');

    }

    public function edit($id)
    {
        $paymentSale = PaymentSale::findOrFail($id);
        $paymentMethods = PaymentMethod::all();
        return view('paymentsale.edit', compact('paymentSale', 'paymentMethods'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
            'amount' => 'required|numeric',
        ]);

        $paymentSale = PaymentSale::findOrFail($id);
        $paymentSale->update($validatedData);

        return redirect()->route('paymentsales.index')->with('success', 'Payment Sale updated successfully!');
    }

    public function destroy($id)
    {
        $paymentSale = PaymentSale::findOrFail($id);
        $paymentSale->delete();

        return redirect()->route('paymentsales.index')->with('success', 'Payment Sale deleted successfully!');
    }

}
