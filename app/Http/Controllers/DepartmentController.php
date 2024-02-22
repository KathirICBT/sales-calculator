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
    public function delete(Department $department)
    {
        return view('departments.delete', compact('department'));
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect('/departments')->with('success', 'Department deleted successfully!');
    }

    // Search
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $departments = Department::where('dept_name', 'like', "%{$searchTerm}%")->get();

        return view('departments.search', compact('departments'));
    }


}
