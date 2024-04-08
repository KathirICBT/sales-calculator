<?php

namespace App\Http\Controllers;
use App\Models\PettyCashReason;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class PettyCashReasonController extends Controller
{
    public function index()
    {
       //
    }
    
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the request data
            $validatedData = $request->validate([
                'petty_cash_reason' => 'required|string|unique:petty_cash_reasons,reason',
                'expense_category_id' => 'required|exists:expense_categories,id',
                'expense_sub_category_id' => 'required|exists:expense_sub_categories,id',
            ], [
                'petty_cash_reason.unique' => 'The petty cash reason has already been added.',
            ]);

            // Create a new PettyCashReason instance
            $pettyCashReason = new PettyCashReason();
            $pettyCashReason->reason = $validatedData['petty_cash_reason'];
            $pettyCashReason->expense_category_id = $validatedData['expense_category_id'];
            $pettyCashReason->expense_sub_category_id = $validatedData['expense_sub_category_id'];

            // Save the new petty cash reason
            $pettyCashReason->save();            

            // Redirect back with success message
            return redirect()->route('pettycashreason.store')->with('success', 'Expense Reason added successfully!');
        }

        // Load necessary data for the form
        $pettyCashReasons = PettyCashReason::all(); 
        $expenseSubCategories = ExpenseSubCategory::all();
        $expenseCategories = ExpenseCategory::all(); 

        return view('pages.pettyCashReason.create', compact('pettyCashReasons', 'expenseSubCategories', 'expenseCategories'));
    }

    public function fetchExpenseSubCategories($categoryId)
    {
        // Fetch Expense Sub Categories based on the selected Expense Category
        $expenseSubCategories = ExpenseSubCategory::where('category_id', $categoryId)->get();

        return response()->json($expenseSubCategories);
    }

    public function fetchExpenseCategory($subCategoryId)
    {
        // Fetch the Expense Sub Category
        $expenseSubCategory = ExpenseSubCategory::findOrFail($subCategoryId);

        // Return the associated Expense Category
        return response()->json(['category_id' => $expenseSubCategory->category_id]);
    }
    

    public function destroy($id)
    {
        try {
            $pettyCashReason = PettyCashReason::findOrFail($id);
            $pettyCashReason->delete();

            return redirect()->route('pettycashreason.store')->with('success', 'Petty Cash Reason deleted successfully!');
        } catch (QueryException $e) {
            // Check if the error is due to a foreign key constraint violation
            if ($e->errorInfo[1] === 1451) {
                return redirect()->route('pettycashreason.store')->with('error', 'Cannot delete Petty Cash Reason. It is referenced by other records.');
            }

            // If it's another type of error, you can log it for debugging purposes
            Log::error('Error deleting Petty Cash Reason: ' . $e->getMessage());

            // Redirect back with a generic error message
            return redirect()->route('pettycashreason.store')->with('error', 'An error occurred while deleting the Petty Cash Reason.');
        }
    }
    
}