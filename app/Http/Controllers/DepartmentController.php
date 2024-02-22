<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;


class DepartmentController extends Controller
{  

    public function index()
    {
        // Fetch departments from the database
        $departments = Department::all();

        // Pass the departments variable to the view
        return view('departments.index', compact('departments'));
    }

    // Create
    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dept_name' => 'required|string|max:255',
            'other_taking' => 'boolean',
        ]);

        Department::create([
            'dept_name' => $request->input('dept_name'),
            'other_taking' => $request->input('other_taking', false),
        ]);

        return redirect('/departments')->with('success', 'Department created successfully!');
    }

    // Update
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'dept_name' => 'required|string|max:255',
            'other_taking' => 'boolean',
        ]);

        $department->update([
            'dept_name' => $request->input('dept_name'),
            'other_taking' => $request->input('other_taking', false),
        ]);

        return redirect('/departments')->with('success', 'Department updated successfully!');
    }

    // Delete
    public function deleteConfirmation(Department $department)
    {
        return view('departments.delete', compact('department'));
    }

    // Method for deleting the department
    public function destroy($id)
    {
        // Find the department by ID and delete it
        Department::destroy($id);
    
        // Redirect the user back with a success message
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully');
    }
    
    // Search
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $departments = Department::where('dept_name', 'like', "%{$searchTerm}%")->get();

        return view('departments.search', compact('departments'));
    }


}
