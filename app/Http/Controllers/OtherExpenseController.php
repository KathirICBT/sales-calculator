<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use App\Models\PaymentType;
use App\Models\PettyCashReason;

use App\Models\OtherExpense;
use Illuminate\Http\Request;

class OtherExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shops = Shop::all();
        $pettyCashReasons = PettyCashReason::all();
        $paymentTypes = PaymentType::all();

        return view('otherexpense.store', compact('shops', 'pettyCashReasons', 'paymentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $validatedData = $request->validate([
    //             'shop_id' => 'required|exists:shops,id',
    //             'date' => 'required|date',
    //             'pettyCashReason_id.*' => 'required|exists:petty_cash_reasons,id',
    //             'paymenttype_id.*' => 'required|exists:payment_types,id',
    //             'amount.*' => 'required|numeric|min:0',
    //         ]);
            
    //         foreach ($validatedData['pettyCashReason_id'] as $key => $reasonId) {
    //             OtherExpense::create([
    //                 'shop_id' => $validatedData['shop_id'],
    //                 'date' => $validatedData['date'],
    //                 'expense_reason_id' => $reasonId,
    //                 'paymenttype_id' => $validatedData['paymenttype_id'][$key],
    //                 'amount' => $validatedData['amount'][$key],
    //             ]);
    //         }
            
    //         return redirect()->back()->with('success', 'Other expenses added successfully.');
    //     }

    //     $shops = Shop::all();
    //     $pettyCashReasons = PettyCashReason::all();
    //     $paymentTypes = PaymentType::all();
    //     $otherExpenses = OtherExpense::all();
        
    //     return view('pages.expense.otherExpense.create',compact('pettyCashReasons', 'paymentTypes','shops','otherExpenses'));
    // }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'shop_id' => 'required|exists:shops,id',
                'date' => 'required|date',
                'pettyCashReason_id.*' => 'required|exists:petty_cash_reasons,id',
                'paymenttype_id.*' => 'required|exists:payment_types,id',
                'amount.*' => 'required|numeric|min:0',
            ]);
            
            foreach ($validatedData['pettyCashReason_id'] as $key => $reasonId) {
                // Check if a similar OtherExpense already exists
                $existingExpense = OtherExpense::where('shop_id', $validatedData['shop_id'])
                    ->where('expense_reason_id', $reasonId)
                    ->where('paymenttype_id', $validatedData['paymenttype_id'][$key])
                    ->where('date', $validatedData['date'])
                    ->first();
                if ($existingExpense) {
                    // If exists, update the amount
                    $existingExpense->amount += $validatedData['amount'][$key];
                    $existingExpense->save();
                } else {
                    // If not, create a new OtherExpense record
                    OtherExpense::create([
                        'shop_id' => $validatedData['shop_id'],
                        'date' => $validatedData['date'],
                        'expense_reason_id' => $reasonId,
                        'paymenttype_id' => $validatedData['paymenttype_id'][$key],
                        'amount' => $validatedData['amount'][$key],
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Other expenses added successfully.');
        }

        $shops = Shop::all();
        $pettyCashReasons = PettyCashReason::all();
        $paymentTypes = PaymentType::all();
        $otherExpenses = OtherExpense::all();
        
        return view('pages.expense.otherExpense.create',compact('pettyCashReasons', 'paymentTypes','shops','otherExpenses'));
    }


    /**
     * Display the specified resource.
     */
    public function show(OtherExpense $otherExpense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $otherExpense = OtherExpense::findOrFail($id);
        return response()->json($otherExpense);
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date',
            'pettyCashReason_id' => 'required|exists:petty_cash_reasons,id',
            'paymenttype_id' => 'required|exists:payment_types,id',
            'amount' => 'required|numeric|min:0',
        ]);

        // Rename the 'pettyCashReason_id' to 'expense_reason_id' to match the database column
        $validatedData['expense_reason_id'] = $validatedData['pettyCashReason_id'];
        unset($validatedData['pettyCashReason_id']);

        // Find the existing OtherExpense record with the same attributes
        $existingExpense = OtherExpense::where('shop_id', $validatedData['shop_id'])
            ->where('date', $validatedData['date'])
            ->where('paymenttype_id', $validatedData['paymenttype_id'])
            ->where('expense_reason_id', $validatedData['expense_reason_id'])
            ->where('id', '!=', $id) // Exclude the record being updated
            ->first();

        if ($existingExpense) {
            // If existing record found, add the amount to it
            $existingExpense->amount += $validatedData['amount'];
            $existingExpense->save();
            
            // Delete the record being updated
            $otherExpense = OtherExpense::findOrFail($id);
            $otherExpense->delete();
        } else {
            // If no existing record found, proceed with updating
            $otherExpense = OtherExpense::findOrFail($id);
            $otherExpense->update($validatedData);
        }

        return redirect()->back()->with('success', 'Other Expense updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $otherExpense = OtherExpense::findOrFail($id);
        $otherExpense->delete();

        return redirect()->route('otherexpense.store')->with('success', 'Other Expense deleted successfully!');
    }
}
