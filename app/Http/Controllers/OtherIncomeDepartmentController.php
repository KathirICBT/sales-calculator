<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtherIncomeDepartment;

class OtherIncomeDepartmentController extends Controller
{
    
    // Index method to fetch and display all other income departments
    public function index()
    {
        $otherIncomeDepartments = OtherIncomeDepartment::all();
        return view('pages.income.otherIncomeDepartment.create', compact('otherIncomeDepartments'));
    }

    // Create method to return the create view
    public function create()
    {
        return view('other_income_departments.create');
    }

    // Store method to store a newly created other income department
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'income_name' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'subcategory' => 'required|string|in:Direct Income,Calculated Income',
            ]);

            OtherIncomeDepartment::create([
                'income_name' => $request->input('income_name'),
                'category' => $request->input('category'),
                'subcategory' => $request->input('subcategory'),
            ]);

            return redirect()->route('other_income_departments.store')->with('success', 'Other Income Department created successfully!');
        }
        $otherIncomeDepartments = OtherIncomeDepartment::all();
        return view('pages.income.otherIncomeDepartment.create', compact('otherIncomeDepartments'));
    }

    // Edit method to return the edit view
    public function edit(OtherIncomeDepartment $otherIncomeDepartment)
    {
        return response()->json($otherIncomeDepartment);
    }
    // Update method to update the specified other income department
//     public function update(Request $request, OtherIncomeDepartment $otherIncomeDepartment)
// {
//     $request->validate([
//         'income_name' => 'required|string|max:255',
//         'category' => 'required|string|max:255',
//         'subcategory' => 'required|string|in:Direct Income,Calculated Income',
//     ]);

//     $otherIncomeDepartment->update([
//         'income_name' => $request->input('income_name'),
//         'category' => $request->input('category'),
//         'subcategory' => $request->input('subcategory'),
//     ]);

//     return redirect()->route('other_income_departments.store')->with('success', 'Other Income Department updated successfully!');
// }


public function update(Request $request, OtherIncomeDepartment $otherIncomeDepartment)
{
    $request->validate([
        'income_name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
    ]);

    $updated = $otherIncomeDepartment->update([
        'income_name' => $request->input('income_name'),
        'category' => $request->input('category'),
        'subcategory' => $request->input('edit_subcategory'),
    ]);

    if ($updated !== false) {             
        return redirect()->route('other_income_departments.store')->with('success', 'Other Income Department updated successfully!');
    } else {            
        return redirect()->route('other_income_departments.store')->with('error', 'Failed to update Other Income Department!');
    }
}

    // Method for deleting the other income department
    public function destroy(OtherIncomeDepartment $otherIncomeDepartment)
    {
        $otherIncomeDepartment->delete();
        return redirect()->route('other_income_departments.store')->with('success', 'Other Income Department deleted successfully!');
    }

    // Search method to search for other income departments based on the provided search term
    // public function search(Request $request)
    // {
    //     $searchTerm = $request->input('search');
    //     $otherIncomeDepartments = OtherIncomeDepartment::where('income_name', 'like', "%{$searchTerm}%")
    //         ->orWhere('category', 'like', "%{$searchTerm}%")
    //         ->get();

    //     return view('other_income_departments.search', compact('otherIncomeDepartments'));
    // }
}
