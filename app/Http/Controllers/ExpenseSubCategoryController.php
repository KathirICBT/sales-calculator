<?php

namespace App\Http\Controllers;
use App\Models\ExpenseSubCategory;
use App\Models\ExpenseCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ExpenseSubCategoryController extends Controller
{
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            
            $validatedData = $request->validate([
                'category_id' => 'required|exists:expense_categories,id',
                'sub_category' => 'required|string|max:255|unique:expense_sub_categories,sub_category',
                'report_order_number' => 'nullable|integer',
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
            'report_order_number' => 'nullable|integer',
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
        try {
            // Attempt to find the ExpenseSubCategory with the given ID
            $expenseSubCategory = ExpenseSubCategory::findOrFail($id);
            
            // If found, delete the ExpenseSubCategory
            $expenseSubCategory->delete();

            // Redirect with success message
            return redirect()->route('expense_sub_category.store')->with('success', 'Sub Category deleted successfully!');
        } catch (QueryException $e) {
            // Check if the error is due to a foreign key constraint violation
            if ($e->errorInfo[1] === 1451) {
                // Redirect with error message for foreign key constraint violation
                return redirect()->route('expense_sub_category.store')->with('error', 'Cannot delete Sub Category. It is referenced by other records.');
            }

            // If it's another type of error, log it for debugging purposes
            Log::error('Error deleting Sub Category: ' . $e->getMessage());

            // Redirect with generic error message
            return redirect()->route('expense_sub_category.store')->with('error', 'An error occurred while deleting the Sub Category.');
        }
    }
}
