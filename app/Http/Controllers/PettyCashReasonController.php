<?php

namespace App\Http\Controllers;
use App\Models\PettyCashReason;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
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
                'supplier' => 'required|in:Supplier,Other',
            ], [
                'petty_cash_reason.unique' => 'The petty cash reason has already been added.',
            ]);

            // Create a new PettyCashReason instance
            $pettyCashReason = new PettyCashReason();
            $pettyCashReason->reason = $validatedData['petty_cash_reason'];
            $pettyCashReason->expense_category_id = $validatedData['expense_category_id'];
            $pettyCashReason->expense_sub_category_id = $validatedData['expense_sub_category_id'];
            $pettyCashReason-> supplier= $validatedData['supplier'];

            // Save the new petty cash reason
            $pettyCashReason->save();            

            // Redirect back with success message
            return redirect()->route('pettycashreason.store')->with('success', 'Expense Reason added successfully!');
        }

        // Load necessary data for the form
        $pettyCashReasons = PettyCashReason::all(); 
        $expenseSubCategories = ExpenseSubCategory::all();
        $expenseCategories = ExpenseCategory::all(); 

        return view('pages.expense.pettyCashReason.create', compact('pettyCashReasons', 'expenseSubCategories', 'expenseCategories'));
    }

    // Expense Sub Catergories =======================================

    public function fetchExpenseSubCategories($categoryId)
    {
        // Fetch Expense Sub Categories based on the selected Expense Category
        $expenseSubCategories = ExpenseSubCategory::where('category_id', $categoryId)->get();

        return response()->json($expenseSubCategories);
    }

    // Expense Sub Catergories End =======================================

    // Expense Catergories =======================================
    public function fetchExpenseCategory($subCategoryId)
    {
        // Fetch the Expense Sub Category
        $expenseSubCategory = ExpenseSubCategory::findOrFail($subCategoryId);

        // Return the associated Expense Category
        return response()->json(['category_id' => $expenseSubCategory->category_id]);
    }
    // Expense Catergories ==================================================================

    // UPDATE ===============================================================================
    public function edit($id)
    {
        $pettyCashReason = PettyCashReason::findOrFail($id);
        return response()->json($pettyCashReason);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'model_petty_cash_reason' => [
                'required',
                'string',
                Rule::unique('petty_cash_reasons', 'reason')->ignore($id),
            ],
            'model_expense_category_id' => 'required|exists:expense_categories,id',
            'model_expense_sub_category_id' => 'required|exists:expense_sub_categories,id',
            'model_supplier' => [
                'required',
                Rule::in(['Supplier', 'Other']), // Validate against 'Supplier' or 'Other'
            ],
        ], [
            'model_petty_cash_reason.unique' => 'The petty cash reason has already been added.',
        ]);

        // Find the petty cash reason by ID
        $pettyCashReason = PettyCashReason::findOrFail($id);
        
        // Update the petty cash reason attributes
        $pettyCashReason->reason = $validatedData['model_petty_cash_reason'];
        $pettyCashReason->expense_category_id = $validatedData['model_expense_category_id'];
        $pettyCashReason->expense_sub_category_id = $validatedData['model_expense_sub_category_id'];
        $pettyCashReason-> supplier= $validatedData['model_supplier'];

        // Save the updated petty cash reason
        $pettyCashReason->save();            

        // Redirect back with success message
        return redirect()->back()->with('success', 'Expense Reason updated successfully!');
    }

    //=======================================================================================

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