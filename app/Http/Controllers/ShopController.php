<?php

namespace App\Http\Controllers;
use App\Models\Shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index(){
        $shops = Shop::all();
        return view("shops.view_all_shops", compact("shops"));
    }
    public function view_all(){
        $shops = Shop::all();
        return view("shops.view_all_shops", compact("shops"));
    }
    
    public function view_shop()
    {
        return view('shops.add_shop');
    }

    // public function store(Request $request){
        
    //     // $validatedData = $request->validate([
    //     //     'name'=> 'required|max:255|min:5'            
    //     // ]);

    //     // Shop::create([
    //     //     'name'=> $validatedData['name'],
    //     //     'phone'=> $request->input('phone'),
    //     //     'address'=> $request->input('address')
    //     //     ]);

    //     $request->validate([
    //         'name'=> 'required|max:255|min:5'            
    //     ]);

    //     Shop::create(request()->all());

    //     return redirect()->route('shop.add')->with('success','Shop Created!');
    // }

    // public function store(Request $request){
    //     if ($request->isMethod('post')) {
    //         $request->validate([
    //             'name'=> 'required|max:255|min:5'            
    //         ]);

    //         Shop::create(request()->all());

    //         return redirect()->route('shop.store')->with('success','Shop Created!');
    //     }
    //     $shops = Shop::all();
    //     return view('pages.shop.create', compact('shops'));
    // }

    public function store(Request $request) {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|max:255|min:5',
                'phone' => 'required',
                'address' => 'required'            
            ]);
    
            Shop::create($request->all());
    
            return redirect()->route('shop.store')->with('success', 'Shop Created!');
        }
    
        $shops = Shop::all();
        $shopCount = $shops->count(); // Count the number of shops
    
        return view('pages.shop.create', compact('shops', 'shopCount'));
    }

    // public function store(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $request->validate([
    //             'name' => 'required|max:255|min:5',
    //             'phone' => 'required',
    //             'address' => 'required'
    //         ]);

    //         Shop::create([
    //             'name' => $request->name,
    //             'phone' => $request->phone,
    //             'address' => $request->address
    //         ]);

    //         return redirect()->route('shop.create')->with('success', 'Shop Created!');
    //     }

    //     $shops = Shop::all();
    //     $shopCount = $shops->count(); // Count the number of shops

    //     return view('pages.shop.create', compact('shops', 'shopCount'));
    // }

    


    public function update_view(Shop $shop){
        return response()->json($shop);
    }

    // public function update(Request $request, Shop $shop){
        
    //     // $validatedData = $request->validate([
    //     //     'name'=> 'required|max:255|min:5'            
    //     // ]);

    //     // $shop->update([
    //     //     'name'=> $validatedData['name'],
    //     //     'phone'=> $request->input('phone'),
    //     //     'address'=> $request->input('address')
    //     // ]);

    //     $request->validate([
    //         'name'=> 'required|max:255|min:5'            
    //     ]);

    //     $shop->update(request()->all());

    //     return redirect()->route('shop.view')->with('success','Updeted Shop Record!');
    // }
    public function update(Request $request, Shop $shop){

        $request->validate([
            'name'=> 'required|max:255|min:5',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $updated=$shop->update(request()->all());
        
        if ($updated) {
            // Redirect back with success message
            return redirect()->route('shop.store')->with('success', 'shop updated successfully!');
        } else {
            // Redirect back with error message
            return redirect()->route('shop.store')->with('error', 'Failed to update shop !');
        }

        
    }

    // public function destroy(Shop $shop){
    //     $shop->delete();
    //     return redirect()->route('shop.view')->with('success','Delete Shop!');
    // }

    // public function destroy($id){
    //     Shop::where('id', $id)->firstOrFail()->delete();
    //     return redirect()->route('shop.view')->with('success','Delete Shop!');
    // }

    public function destroy($id){
        $shop = Shop::find($id);
        if(is_null($shop)){
            return redirect()->route('shop.store')->with('success','Already Deleted Record!');
        }else{
            $shop->delete();
            return redirect()->route('shop.store')->with('success','Deleted Shop!');            
        } 
    }

    

    public function search(Request $request){
        
        $search = $request->input('search');
        $shops = Shop::where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->get();
        return view('shops.search_shop', compact('shops'));
    }

   

    
    

}
