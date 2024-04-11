<?php

namespace App\Http\Controllers;
use App\Models\OtherIncome;
use App\Models\PaymentType;
use App\Models\OtherIncomeDepartment;
use App\Models\Shop;

use Illuminate\Http\Request;

class OtherIncomeController extends Controller
{
    public function index()
    {
        $otherIncomes = OtherIncome::all();
        return view('otherincomes.index', compact('otherIncomes'));
    }

    public function create()
    {
        return view('otherincomes.create');
    }

    // public function store(Request $request)
    // {
        
    //     if ($request->isMethod('post')) {            
    //         $validatedData = $request->validate([
    //             'shop_id' => 'required|exists:shops,id',
    //             'date' => 'required|date',
    //             'other_income_department_id.*' => 'required|exists:other_income_departments,id',
    //             'paymenttype_id.*' => 'required|exists:payment_types,id',
    //             'amount.*' => 'required|numeric|min:0',
    //         ]);
    
    //         $shopId = $validatedData['shop_id'];
    //         $date = $validatedData['date'];
    //         $otherIncomesData = [];
    
    //         foreach ($validatedData['other_income_department_id'] as $key => $departmentId) {
    //             $otherIncomesData[] = [
    //                 'shop_id' => $shopId,
    //                 'date' => $date,
    //                 'other_income_department_id' => $departmentId,
    //                 'paymenttype_id' => $validatedData['paymenttype_id'][$key],
    //                 'amount' => $validatedData['amount'][$key],
    //             ];
    //         }
    
    //         OtherIncome::insert($otherIncomesData);
    //         //OtherIncome::create($otherIncomesData);
    
    

    //         return redirect()->route('otherincome.store')->with('success', 'Other Income added successfully!');
    //     }
    //     $other_income_departments = OtherIncomeDepartment::all();
    //     $paymentTypes = PaymentType::all();
    //     $otherIncomes = OtherIncome::all();
    //     $shops = Shop::all();
        
    //     return view('pages.income.otherIncome.create',compact('other_income_departments', 'paymentTypes','otherIncomes','shops')); // You may need to adjust the view path
    // }


    // public function store(Request $request)
    // {
        
    //     if ($request->isMethod('post')) {
    //         $validatedData = $request->validate([
    //             'shop_id' => 'required|exists:shops,id',
    //             'date' => 'required|date',
    //             'other_income_department_id.*' => 'required|exists:other_income_departments,id',
    //             'paymenttype_id.*' => 'required|exists:payment_types,id',
    //             'amount.*' => 'required|numeric|min:0',
    //         ]);
            
    //         foreach ($validatedData['other_income_department_id'] as $key => $departmentId) {
    //             OtherIncome::create([
    //                 'shop_id' => $validatedData['shop_id'],
    //                 'date' => $validatedData['date'],
    //                 'other_income_department_id' => $departmentId,
    //                 'paymenttype_id' => $validatedData['paymenttype_id'][$key],
    //                 'amount' => $validatedData['amount'][$key],
    //             ]);
    //         }
            
    //         return redirect()->back()->with('success', 'Other income added successfully.');
    //     }
    //     $other_income_departments = OtherIncomeDepartment::all();
    //     $paymentTypes = PaymentType::all();
    //     $otherIncomes = OtherIncome::all();
    //     $shops = Shop::all();
        
    //     return view('pages.income.otherIncome.create',compact('other_income_departments', 'paymentTypes','otherIncomes','shops')); // You may need to adjust the view path
    // }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'shop_id' => 'required|exists:shops,id',
                'date' => 'required|date',
                'other_income_department_id.*' => 'required|exists:other_income_departments,id',
                'paymenttype_id.*' => 'required|exists:payment_types,id',
                'amount.*' => 'required|numeric|min:0',
            ]);
            
            foreach ($validatedData['other_income_department_id'] as $key => $departmentId) {
                // Check if there's an existing record with the same attributes
                $existingIncome = OtherIncome::where('shop_id', $validatedData['shop_id'])
                    ->where('date', $validatedData['date'])
                    ->where('other_income_department_id', $departmentId)
                    ->where('paymenttype_id', $validatedData['paymenttype_id'][$key])
                    ->first();

                if ($existingIncome) {
                    // If exists, update the amount
                    $existingIncome->amount += $validatedData['amount'][$key];
                    $existingIncome->save();
                } else {
                    // If not, create a new OtherIncome record
                    OtherIncome::create([
                        'shop_id' => $validatedData['shop_id'],
                        'date' => $validatedData['date'],
                        'other_income_department_id' => $departmentId,
                        'paymenttype_id' => $validatedData['paymenttype_id'][$key],
                        'amount' => $validatedData['amount'][$key],
                    ]);
                }
            }
            
            return redirect()->back()->with('success', 'Other income added successfully.');
        }

        $other_income_departments = OtherIncomeDepartment::all();
        $paymentTypes = PaymentType::all();
        $otherIncomes = OtherIncome::all();
        $shops = Shop::all();
        
        return view('pages.income.otherIncome.create', compact('other_income_departments', 'paymentTypes', 'otherIncomes', 'shops'));
    }


    public function edit($id)
    {
        $otherIncome = OtherIncome::findOrFail($id);
        return response()->json($otherIncome);
    }

    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'shop_id' => 'required|exists:shops,id',
    //         'date' => 'required|date',
    //         'other_income_department_id' => 'required|exists:other_income_departments,id',
    //         'paymenttype_id' => 'required|exists:payment_types,id',
    //         'amount' => 'required|numeric|min:0',
    //     ]);

    //     $otherIncome = OtherIncome::findOrFail($id);
    //     $otherIncome->update($validatedData);

    //     return redirect()->back()->with('success', 'Other Income updated successfully.');
    // }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date',
            'other_income_department_id' => 'required|exists:other_income_departments,id',
            'paymenttype_id' => 'required|exists:payment_types,id',
            'amount' => 'required|numeric|min:0',
        ]);

        // Find the existing OtherIncome record with the same attributes
        $existingIncome = OtherIncome::where('shop_id', $validatedData['shop_id'])
            ->where('date', $validatedData['date'])
            ->where('other_income_department_id', $validatedData['other_income_department_id'])
            ->where('paymenttype_id', $validatedData['paymenttype_id'])
            ->where('id', '!=', $id) // Exclude the record being updated
            ->first();

        if ($existingIncome) {
            // If existing record found, add the amount to it
            $existingIncome->amount += $validatedData['amount'];
            $existingIncome->save();
            
            // Delete the record being updated
            $otherIncome = OtherIncome::findOrFail($id);
            $otherIncome->delete();
        } else {
            // If no existing record found, proceed with updating
            $otherIncome = OtherIncome::findOrFail($id);
            $otherIncome->update($validatedData);
        }

        return redirect()->back()->with('success', 'Other Income updated successfully.');
    }


    public function destroy($id)
    {
        $otherIncome = OtherIncome::findOrFail($id);
        $otherIncome->delete();

        return redirect()->route('otherincome.store')->with('success', 'Other Income deleted successfully!');
    }
}
