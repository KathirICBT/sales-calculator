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
        $billImages = BillImage::all();
        return view('pages.BillImages.create', compact('staffs', 'shops','billImages'));
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

    public function edit(BillImage $billImages )
    {
        // $billImage = BillImage::with('staff', 'shop')->find($id);
        // if (!$billImage) {
        //     return abort(404); // Handle case when record is not found
        // }
        // $staffs = Staff::all();
        // $shops = Shop::all();
        // return view('pages.billImages.create', compact('billImage', 'staffs', 'shops'));
        return response()->json($billImages);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'staff_id' => 'required|exists:staffs,id',
            'shop_id' => 'nullable|exists:shops,id',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $billImage = BillImage::find($id);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $billImage->image = 'images/' . $imageName;
        }

        $billImage->staff_id = $request->staff_id;
        $billImage->shop_id = $request->shop_id;
        $billImage->date = $request->date;
        $billImage->save();

        return back()->with('success', 'Bill Image updated successfully.');
    }

    public function destroy($id)
{
    $billImage = BillImage::find($id);
    $billImage->delete();

    return back()->with('success', 'Bill Image deleted successfully.');
}

}
