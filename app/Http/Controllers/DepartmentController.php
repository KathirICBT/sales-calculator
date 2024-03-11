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

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'dept_name' => 'required|string|max:255',
    //         'other_taking' => 'boolean',
    //     ]);

    //     Department::create([
    //         'dept_name' => $request->input('dept_name'),
    //         'other_taking' => $request->input('other_taking', false),
    //     ]);

    //     return redirect('/departments')->with('success', 'Department created successfully!');
    // }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'dept_name' => 'required|string|max:255',
                'other_taking' => 'boolean',
            ]);

            Department::create([
                'dept_name' => $request->input('dept_name'),
                'other_taking' => $request->input('other_taking', false),
            ]);

            return redirect()->route('departments.store')->with('success', 'departments registered successfully!');
        }
        $departments = Department::all();        
        return view('pages.department.create', compact('departments'));

    }

    // // Update
    // public function edit(Department $department)
    // {
        
    //     return view('departments.edit', compact('department'));
    // }

     // Update
     public function edit(Department $department)
     {
        return response()->json($department);
     }

    // public function update(Request $request, Department $department)
    // {
    //     $request->validate([
    //         'dept_name' => 'required|string|max:255',
    //         'other_taking' => 'boolean',
    //     ]);

    //     $department->update([
    //         'dept_name' => $request->input('dept_name'),
    //         'other_taking' => $request->input('other_taking', false),
    //     ]);

    //     return redirect('/departments')->with('success', 'Department updated successfully!');
    // }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'dept_name' => 'required|string|max:255',
            'other_taking' => 'boolean',
        ]);

        $updated= $department->update([
            'dept_name' => $request->input('dept_name'),
            'other_taking' => $request->input('other_taking', false),
        ]);

        if ($updated) {
            // Redirect back with success message
            return redirect()->route('departments.store')->with('success', 'department updated successfully!');
        } else {
            // Redirect back with error message
            return redirect()->route('departments.store')->with('error', 'Failed to update department !');
        }
    }

    // Delete
    public function deleteConfirmation(Department $department)
    {
        return view('departments.delete', compact('department'));
    }

    // Method for deleting the department
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.store')->with('success', 'Staff member deleted successfully!');
    }
    
    // Search
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $departments = Department::where('dept_name', 'like', "%{$searchTerm}%")->get();

        return view('departments.search', compact('departments'));
    }


}
