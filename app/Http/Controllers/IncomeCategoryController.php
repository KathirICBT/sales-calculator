<?php

namespace App\Http\Controllers;

use App\Models\IncomeCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class IncomeCategoryController extends Controller
{
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {        
            $validatedData = $request->validate([
                'income_category' => 'required|string|max:255|unique:income_categories,category',            
            ], [
                'income_category.unique' => 'The Income Category has already been added.',
            ]);
            
            IncomeCategory::create(['category' => $validatedData['income_category']]); 
            
            return redirect()->route('income_category.store')->with('success', 'Income Category added successfully!');
        } 
        $incomeCategories = IncomeCategory::all();
        return view('pages.income.income_category.create', compact('incomeCategories'));
    }


    public function edit($id)
    {
        $incomeCategory = IncomeCategory::findOrFail($id);
        return response()->json($incomeCategory);
    }


    public function update(Request $request, $id)
    {        
        $validatedData = $request->validate([
            'incomeCategory' => 'required|string|max:255|unique:income_categories,category,' . $id,            
        ], [
            'incomeCategory.unique' => 'The Income Category has already been added.',
        ]);
       
        $incomeCategory = IncomeCategory::findOrFail($id);
       
        $incomeCategory->update(['category' => $validatedData['incomeCategory']]);
        
        return redirect()->back()->with('success', 'Income Category updated successfully.');
    }


    public function destroy($id)
    {
        try {
            // Attempt to find the IncomeCategory with the given ID
            $incomeCategory = IncomeCategory::findOrFail($id);
            
            // If found, delete the IncomeCategory
            $incomeCategory->delete();

            // Redirect with success message
            return redirect()->route('income_category.store')->with('success', 'Income Category deleted successfully!');
        } catch (QueryException $e) {
            // Check if the error is due to a foreign key constraint violation
            if ($e->errorInfo[1] === 1451) {
                // Redirect with error message for foreign key constraint violation
                return redirect()->route('income_category.store')->with('error', 'Cannot delete Income Category. It is referenced by other records.');
            }

            // If it's another type of error, log it for debugging purposes
            Log::error('Error deleting Income Category: ' . $e->getMessage());

            // Redirect with generic error message
            return redirect()->route('income_category.store')->with('error', 'An error occurred while deleting the Income Category.');
        }
    }
}
