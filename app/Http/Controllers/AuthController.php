<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() {
        return view("auth.login");
    }
    // public function authenticate(){        

    //     $validated = request()->validate([
    //         "email"=> "required|email",
    //         "password"=> "required"
    //         ]);

    //         if(auth()->attempt($validated)) {
    //             request()->session()->regenerate();
    //             return redirect()->route("dashboard");
    //         }
    //     return redirect()->route("auth.login")->withErrors([
    //         "email"=> "No matching user found wiht the provided email and password",
    //         "password"=> "No matching user found wiht the provided email and password"
    //     ]);

    // }


    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('staff')->attempt($credentials)) {
            // Authentication passed
            $user = Auth::guard('staff')->user();
            return redirect()->route("dashboard")->with('username', $user->username);
        }

        // Authentication failed
        return redirect()->route("auth.login")->withErrors([
            "email"=> "No matching user found wiht the provided email and password",
            "password"=> "No matching user found wiht the provided email and password"
        ]);
    }

}
