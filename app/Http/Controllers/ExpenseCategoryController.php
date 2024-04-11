<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

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
        try {
            // Attempt to find the ExpenseCategory with the given ID
            $expenseCategory = ExpenseCategory::findOrFail($id);
            
            // If found, delete the ExpenseCategory
            $expenseCategory->delete();

            // Redirect with success message
            return redirect()->route('expense_category.store')->with('success', 'Expense Category deleted successfully!');
        } catch (QueryException $e) {
            // Check if the error is due to a foreign key constraint violation
            if ($e->errorInfo[1] === 1451) {
                // Redirect with error message for foreign key constraint violation
                return redirect()->route('expense_category.store')->with('error', 'Cannot delete Expense Category. It is referenced by other records.');
            }

            // If it's another type of error, log it for debugging purposes
            Log::error('Error deleting Expense Category: ' . $e->getMessage());

            // Redirect with generic error message
            return redirect()->route('expense_category.store')->with('error', 'An error occurred while deleting the Expense Category.');
        }
    }

}
