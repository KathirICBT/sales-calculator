<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;

use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {        
            $validatedData = $request->validate([
                'expense_category' => 'required|string|max:255|unique:expense_categories,category',            
            ], [
                'expense_category.unique' => 'The Expense Category has already been added.',
            ]);
            
            ExpenseCategory::create(['category' => $validatedData['expense_category']]); 
            
            return redirect()->route('expense_category.store')->with('success', 'Expense Category added successfully!');
        } 
        $expenseCategories = ExpenseCategory::all();
        return view('pages.expense.expense_category.create', compact('expenseCategories'));
    }


    public function edit($id)
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);
        return response()->json($expenseCategory);
    }


    public function update(Request $request, $id)
    {        
        $validatedData = $request->validate([
            'expenseCategory' => 'required|string|max:255|unique:expense_categories,category,' . $id,            
        ], [
            'expenseCategory.unique' => 'The Expense Category has already been added.',
        ]);
       
        $expenseCategory = ExpenseCategory::findOrFail($id);
       
        $expenseCategory->update(['category' => $validatedData['expenseCategory']]);
        
        return redirect()->back()->with('success', 'Expense Category updated successfully.');
    }


    public function destroy($id)
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);
        $expenseCategory->delete();

        return redirect()->route('expense_category.store')->with('success', 'Expense Category deleted successfully!');
    }

}
