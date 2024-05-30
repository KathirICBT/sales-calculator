<?php

namespace App\Http\Controllers;
use App\Models\Shop;
use App\Models\Staff;
use App\Models\BillImage;
use Illuminate\Http\Request;

class BillImageController extends Controller
{
    public function create()
    {
        $staffs = Staff::all();
        $shops = Shop::all();
        return view('pages.billImages.create', compact('staffs', 'shops'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staffs,id',
            'shop_id' => 'nullable|exists:shops,id',
            'date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        BillImage::create([
            'staff_id' => $request->staff_id,
            'shop_id' => $request->shop_id,
            'date' => $request->date,
            'image' => 'images/' . $imageName,
        ]);

        return back()->with('success', 'Image uploaded successfully.');
    }
}
