<?php

namespace App\Http\Controllers;
use App\Models\Paymentsale;
use App\Models\Paymentmethod;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Shift;

class PaymentsaleController extends Controller
{
//     public function index()
//     {
//         $paymentSales = PaymentSale::all();
//         return view('paymentsale.index', compact('paymentSales'));
//     }

//     public function create()
// {
//     $paymentmethods = Paymentmethod::all();
//     $staffs = Staff::all();

//     return view('pages.sales.create', compact('paymentmethods', 'staffs'));
// }



//     public function store(Request $request)
//     {

//         if ($request->isMethod('post')) {
//             $validatedData = $request->validate([
//                 'paymentmethod_id' => 'required|exists:paymentmethods,id',
//                 'amount' => 'required|numeric',
//             ]);


//             Paymentsale::create($validatedData);
            
            
//             return redirect()->back()->with('success', 'Payment sale created successfully.');
    
//         }
//         $paymentSales = PaymentSale::all();
//         $paymentmethods=Paymentmethod::all();
//         $staffs = Staff::all();    
//         return view('pages.sales.create', compact('paymentmethods','staffs'));

//     }

//     public function edit($id)
//     {
//         $paymentSale = PaymentSale::findOrFail($id);
//         $paymentMethods = PaymentMethod::all();
//         $staffs = Staff::all();
//         return view('paymentsale.edit', compact('paymentSale', 'paymentMethods', 'staffs'));
//     }

//     public function update(Request $request, $id)
//     {
//         $validatedData = $request->validate([
//             'paymentmethod_id' => 'required|exists:paymentmethods,id',
//             'amount' => 'required|numeric',
//             'staff_id' => 'required|exists:staffs,id',
//         ]);

//         $paymentSale = PaymentSale::findOrFail($id);
//         $paymentSale->update($validatedData);

//         return redirect()->route('paymentsales.index')->with('success', 'Payment Sale updated successfully!');
//     }

//     public function destroy($id)
//     {
//         $paymentSale = PaymentSale::findOrFail($id);
//         $paymentSale->delete();

//         return redirect()->route('paymentsales.index')->with('success', 'Payment Sale deleted successfully!');
//     }

public function index()
    {
        $paymentSales = Paymentsale::all();
        return view('paymentsale.index', compact('paymentSales'));
    }

    // public function store(Request $request)
    // {
    //     // Validation
    //     $request->validate([
    //         'paymentmethod_id' => 'required',
    //         'amount' => 'required|numeric',
            
    //     ]);
    //     $lastShiftId = Shift::latest()->value('id');
    //     // Create PaymentSale instance
    //     PaymentSale::create([
    //         'paymentmethod_id' => $request->paymentmethod_id,
    //         'amount' => $request->amount,
    //         'shift_id' => $lastShiftId ,
    //         // Add other fields as needed
    //     ]);

    //     // Redirect or return a response as needed
    //     return redirect()->back()->with('success', 'Payment sale details added successfully!');
    // }
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'paymentmethod_id' => 'required|array',
            'amount' => 'required|array',
            'paymentmethod_id.*' => 'required|exists:paymentmethods,id', // Ensure each payment method exists in the database
            'amount.*' => 'required|numeric|min:0', // Ensure each amount is numeric and non-negative
        ]);

        // Check if both arrays have the same length
        if (count($request->paymentmethod_id) !== count($request->amount)) {
            // If not, return with an error message
            return redirect()->back()->with('error', 'Each payment method must have a corresponding amount.');
        }

        // Get the last shift ID
        $lastShiftId = Shift::latest()->value('id');

        // Loop through each payment method and amount
        foreach ($request->paymentmethod_id as $key => $paymentMethodId) {
            // Create PaymentSale instance for each entry
            PaymentSale::create([
                'paymentmethod_id' => $paymentMethodId,
                'amount' => $request->amount[$key],
                'shift_id' => $lastShiftId, // Include the last shift ID
                // Add other fields as needed
            ]);
        }

        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Payment sale details added successfully!');
    }


    public function edit($id)
    {
        $paymentSale = Paymentsale::findOrFail($id);
        $paymentMethods = Paymentmethod::all();
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

        $paymentSale = Paymentsale::findOrFail($id);
        $paymentSale->update($validatedData);

        return redirect()->route('paymentsales.index')->with('success', 'Payment Sale updated successfully!');
    }

    public function destroy($id)
    {
        $paymentSale = Paymentsale::findOrFail($id);
        $paymentSale->delete();

        return redirect()->route('paymentsales.index')->with('success', 'Payment Sale deleted successfully!');
    }

}
