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

    // public function store(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $request->validate([
    //             'dept_name' => 'required|string|max:255',
    //             'other_taking' => 'boolean',
    //             'fuel' => 'boolean',
    //         ]);

    //         Department::create([
    //             'dept_name' => $request->input('dept_name'),
    //             'other_taking' => $request->input('other_taking', false),
    //             'fuel' => $request->input('fuel', false),
                
    //         ]);

    //         return redirect()->route('departments.store')->with('success', 'Departments registered successfully!');
    //     }

    //     $departmentCount = Department::count(); // Count the number of departments
    //     $departments = Department::all();        

    //     return view('pages.department.create', compact('departments', 'departmentCount'));
    // }

    public function store(Request $request)
{
    if ($request->isMethod('post')) {
        $request->validate([
            'dept_name' => 'required|string|max:255|unique:departments', // Add unique validation rule
            'other_taking' => 'boolean',
            'fuel' => 'boolean',
        ]);

        try {
            Department::create([
                'dept_name' => $request->input('dept_name'),
                'other_taking' => $request->input('other_taking', false),
                'fuel' => $request->input('fuel', false),
            ]);

            return redirect()->route('departments.store')->with('success', 'Departments registered successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['dept_name' => 'The department name has already been taken.']);
        }
    }

    $departmentCount = Department::count(); // Count the number of departments
    $departments = Department::all();        

    return view('pages.department.create', compact('departments', 'departmentCount'));
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

    // public function update(Request $request, Department $department)
    // {
    //     $request->validate([
    //         'dept_name' => 'required|string|max:255',
    //         'other_taking' => 'boolean',
    //     ]);

    //     $updated= $department->update([
    //         'dept_name' => $request->input('dept_name'),
    //         'other_taking' => $request->input('other_taking', false),
    //     ]);
        

    //     if ($updated) {
    //         // Redirect back with success message
    //         return redirect()->route('departments.store')->with('success', 'department updated successfully!');
    //     } else {
    //         // Redirect back with error message
    //         return redirect()->route('departments.store')->with('error', 'Failed to update department !');
    //     }
    // }

    // public function update(Request $request, Department $department)
    // {
    //     $request->validate([
    //         'dept_name' => 'required|string|max:255',
            
            
            
    //     ]);

    //     $updated = $department->update([
    //         'dept_name' => $request->input('dept_name'),
    //         'other_taking' => $request->has('other_taking'),
    //         'fuel' => $request->has('fuel'),
    //     ]);        

    //     if ($updated !== false) {             
    //         return redirect()->route('departments.store')->with('success', 'Department updated successfully!');
    //     } else {            
    //         return redirect()->route('departments.store')->with('error', 'Failed to update department!');
    //     }
    // }

    public function update(Request $request, Department $department)
<<<<<<< HEAD
{
    $request->validate([
        'dept_name' => 'required|string|max:255|unique:departments,dept_name,'.$department->id,
        // Ensure that the dept_name is unique, excluding the current department's ID
    ]);
=======
    {
        $request->validate([
            'dept_name' => 'required|string|max:255', 
        ]);
>>>>>>> c09eedca1879d0207fb673851561b88e4a6091e5

    $updated = $department->update([
        'dept_name' => $request->input('dept_name'),
        'other_taking' => $request->has('other_taking'),
        'fuel' => $request->has('fuel'),
    ]);        

    if ($updated) { // $updated will be true if the update was successful
        return redirect()->route('departments.store')->with('success', 'Department updated successfully!');
    } else {
        return redirect()->route('departments.store')->with('error', 'Failed to update department!');
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
