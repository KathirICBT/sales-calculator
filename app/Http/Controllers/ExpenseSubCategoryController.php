<?php

namespace App\Http\Controllers;
use App\Models\ExpenseSubCategory;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseSubCategoryController extends Controller
{
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            
            $validatedData = $request->validate([
                'category_id' => 'required|exists:expense_categories,id',
                'sub_category' => 'required|string|max:255|unique:expense_sub_categories,sub_category',
            ], [
                'sub_category.unique' => 'The sub category has already been added.',
            ]);

            ExpenseSubCategory::create($validatedData);

            return redirect()->route('expense_sub_category.store')->with('success', 'Sub Category added successfully!');
        }
        $expenseSubCategories = ExpenseSubCategory::all();
        $expenseCategories = ExpenseCategory::all();        
        
        return view('pages.expense.expense_sub_category.create',compact('expenseSubCategories','expenseCategories'));
    }


    public function edit($id)
    {
        $expenseSubCategory = ExpenseSubCategory::findOrFail($id);
        return response()->json($expenseSubCategory);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'sub_category' => 'required|string|max:255|unique:expense_sub_categories,sub_category,' . $id,
            // Ensuring sub_category is unique except for the current record with id $id
        ], [
            'sub_category.unique' => 'The sub category has already been added.',
        ]);

        $expenseSubCategory = ExpenseSubCategory::findOrFail($id);
        $expenseSubCategory->update($validatedData);

        return redirect()->back()->with('success', 'Expense Sub Category updated successfully.');
    }


    public function destroy($id)
    {
        $expenseSubCategory = ExpenseSubCategory::findOrFail($id);
        $expenseSubCategory->delete();

        return redirect()->route('expense_sub_category.store')->with('success', 'Sub Category deleted successfully!');
    }
}
