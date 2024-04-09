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
    
            $shopId = $validatedData['shop_id'];
            $date = $validatedData['date'];
            $otherIncomesData = [];
    
            foreach ($validatedData['other_income_department_id'] as $key => $departmentId) {
                $otherIncomesData[] = [
                    'shop_id' => $shopId,
                    'date' => $date,
                    'other_income_department_id' => $departmentId,
                    'paymenttype_id' => $validatedData['paymenttype_id'][$key],
                    'amount' => $validatedData['amount'][$key],
                ];
            }
    
            OtherIncome::insert($otherIncomesData);
    

            return redirect()->route('otherincome.store')->with('success', 'Other Income added successfully!');
        }
        $other_income_departments = OtherIncomeDepartment::all();
        $paymentTypes = PaymentType::all();
        $otherIncomes = OtherIncome::all();
        $shops = Shop::all();
        
        return view('pages.income.otherIncome.create',compact('other_income_departments', 'paymentTypes','otherIncomes','shops')); // You may need to adjust the view path
    }

    public function edit($id)
    {
        $otherIncome = OtherIncome::findOrFail($id);
        return response()->json($otherIncome);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'date' => 'required|date',
            'other_income_department_id' => 'required|exists:other_income_departments,id',
            'paymenttype_id' => 'required|exists:payment_types,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $otherIncome = OtherIncome::findOrFail($id);
        $otherIncome->update($validatedData);

        return redirect()->back()->with('success', 'Other Income updated successfully.');
    }

    public function destroy($id)
    {
        $otherIncome = OtherIncome::findOrFail($id);
        $otherIncome->delete();

        return redirect()->route('otherincome.store')->with('success', 'Other Income deleted successfully!');
    }
}
