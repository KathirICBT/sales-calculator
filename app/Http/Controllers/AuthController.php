<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


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


    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/')->with('success', 'Registration successful. You can now login.');
    }

    public function showuserLoginForm()
    {
        return view('auth.login');
    }

    public function userlogin(Request $request)
    {

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            $user = Auth::user();
            return redirect()->route("dashboard")->with('username', $user->username);
        }
        

        // Authentication failed
        return redirect()->route("auth.login")->withErrors([
            "username"=> "No matching user found wiht the provided username and password",
            "password"=> "No matching user found wiht the provided username and password"
        ]);

    }

}
