<?php

namespace App\Http\Controllers;
use App\Models\Sale;  
use App\Models\Department;
use App\Models\Staff;
use App\Models\Shop;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        // Fetch staff from the database
        $sales= Sale::all();

        // Pass the staff variable to the view
        return view('sales.index', compact('sales'));
    }
   

    public function create()
    {
        $departments = Department::all();
        $shops = Shop::all();
        $staffs = Staff::all();

    
        return view('sales.addsales', compact('departments', 'shops', 'staffs'));
    }


    public function store(Request $request)
    {

        // Validate the request data
        $validatedData = $request->validate([
            'dept_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
            'shop_id' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);
    
        Sale::create($validatedData);
    
        
        return redirect()->route('sales.create')->with('success', 'Sale added successfully!');

    }

    public function edit($id)
    {
        // Retrieve the sale record you want to edit
        $sale = Sale::findOrFail($id);

        // Fetch departments, staffs, and shops
        $departments = Department::all();
        $staffs = Staff::all();
        $shops = Shop::all();

        // Pass the data to the view
        return view('sales.edit', compact('sale', 'departments', 'staffs', 'shops'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validatedData = $request->validate([
            'dept_id' => 'required|numeric',
            'staff_id' => 'required|numeric',
            'shop_id' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $sale->update($validatedData);

        return redirect()->route('sales.index')->with('success', 'Sales details updated successfully!');
    }

    public function deleteConfirmation($id)
    {
        $sale = Sale::findOrFail($id);
        return view('sales.delete', compact('sale'));
    }
    

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sales details deleted successfully!');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Perform a database query to search for sales records based on the foreign key names
        $sales = Sale::select('sales.*', 'departments.dept_name', 'staffs.staff_name', 'shops.name as shop_name')
                    ->join('departments', 'sales.dept_id', '=', 'departments.id')
                    ->join('staffs', 'sales.staff_id', '=', 'staffs.id')
                    ->join('shops', 'sales.shop_id', '=', 'shops.id')
                    ->where('departments.dept_name', 'like', "%$keyword%")
                    ->orWhere('staffs.staff_name', 'like', "%$keyword%")
                    ->orWhere('shops.name', 'like', "%$keyword%")
                    ->get();

        // Pass the search results to the view
        return view('sales.search', ['sales' => $sales]);
    }




}
