<?php

namespace App\Http\Controllers;
use App\Models\Paymentsale;
use App\Models\Paymentmethod;
use Illuminate\Http\Request;
use App\Models\Staff;


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
        $staffs = Staff::all();

    
        return view('paymentsale.create', compact('paymentmethods','staffs'));
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'paymentmethod_id' => 'required|exists:paymentmethods,id',
            'amount' => 'required|numeric',
            'staff_id' => 'required|numeric',
        ]);


        Paymentsale::create($validatedData);
        
        
        return redirect()->route('paymentsale.create')->with('success', 'Paymentsale added successfully!');

    }

    public function edit($id)
    {
        $paymentSale = PaymentSale::findOrFail($id);
        $paymentMethods = PaymentMethod::all();
        $staffs = Staff::all();
        return view('paymentsale.edit', compact('paymentSale', 'paymentMethods', 'staffs'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'paymentmethod_id' => 'required|exists:paymentmethods,id',
            'amount' => 'required|numeric',
            'staff_id' => 'required|exists:staffs,id',
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
