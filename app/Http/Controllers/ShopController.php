<?php

namespace App\Http\Controllers;
use App\Models\Shop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index(){

    }
    public function view_all(){
        $shops = Shop::all();
        return view("shops.view_all_shops", compact("shops"));
    }
    
    public function view_shop()
    {
        return view('shops.add_shop');
    }

    public function store(Request $request){
        
        // $validatedData = $request->validate([
        //     'name'=> 'required|max:255|min:5'            
        // ]);

        // Shop::create([
        //     'name'=> $validatedData['name'],
        //     'phone'=> $request->input('phone'),
        //     'address'=> $request->input('address')
        //     ]);

        $request->validate([
            'name'=> 'required|max:255|min:5'            
        ]);

        Shop::create(request()->all());

        return redirect()->route('shop.add')->with('success','Shop Created!');
    }


    public function update_view(Shop $shop){
        return view('shops.update_shop', compact('shop'));
    }

    public function update(Request $request, Shop $shop){
        
        // $validatedData = $request->validate([
        //     'name'=> 'required|max:255|min:5'            
        // ]);

        // $shop->update([
        //     'name'=> $validatedData['name'],
        //     'phone'=> $request->input('phone'),
        //     'address'=> $request->input('address')
        // ]);

        $request->validate([
            'name'=> 'required|max:255|min:5'            
        ]);

        $shop->update(request()->all());

        return redirect()->route('shop.view')->with('success','Updeted Shop Record!');
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
            return redirect()->route('shop.view')->with('success','Already Deleted Record!');
        }else{
            $shop->delete();
            return redirect()->route('shop.view')->with('success','Deleted Shop!');            
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
