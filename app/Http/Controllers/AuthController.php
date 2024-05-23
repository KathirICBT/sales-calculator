<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login() {
        // If staff is already authenticated, redirect to the staff dashboard
        if(Auth::guard('staff')->check()) {
            return redirect()->route('shifts.index');
        }
        
        // If admin is already authenticated, redirect to the admin dashboard
        if(Auth::check()) {
            return redirect()->route('dashboard');
        }
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


    // public function authenticate(Request $request)
    // {
    //     $credentials = $request->only('username', 'password');

    //     if (Auth::guard('staff')->attempt($credentials)) {
    //         // Authentication passed
    //         request()->session()->regenerate();
    //         $user = Auth::guard('staff')->user();
    //         session(['username' => $user->username]);
    //         return redirect()->route("dashboard")->with('username', $user->username);
    //     }

    //     // Authentication failed
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
            $request->session()->regenerate();
            $user = Auth::guard('staff')->user();
            $request->session()->put('username', $user->username); // Storing username in session
            return redirect()->route("shifts.index");
        }

        // Authentication failed
        return redirect()->route("auth.login")->withErrors([
            "email"=> "No matching user found with the provided email and password",
            "password"=> "No matching user found with the provided email and password"
        ]);
    }

//LOGOUT =============================================================

    public function logout(Request $request)
    {
        auth()->logout();
       // Auth::guard('staff')->logout(); // Log the user out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect()->route('auth.login'); // Redirect to the login page
    }



//====================================================================

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
            return redirect()->route("dashboard")->with('user', $user->username);
        }
        

        // Authentication failed
        return redirect()->route("auth.login")->withErrors([
            "username"=> "No matching user found wiht the provided username and password",
            "password"=> "No matching user found wiht the provided username and password"
        ]);

    }

    // public function showProfile()
    // {
    //     return view('auth.register');
    // }
    public function showProfile()
    {
        // Check if the user is logged in
        if (Auth::guard('staff')->check()) {
            // Get the authenticated staff user
            $staff = Auth::guard('staff')->user();
            
            // Return the staff details
            return view('auth.profile.profile')->with('staff', $staff);
    
        }
    }


    public function authenticateUser(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            $request->session()->regenerate();
            $user = Auth::user();
            $request->session()->put('adminusername', $user->username); // Storing username in session
            return redirect()->route("dashboard");
        }

        // Authentication failed
        return redirect()->route("auth.login")->withErrors([
            "username" => "Invalid username or password",
            "password" => "Invalid username or password"
        ]);
    }


public function showDashboard()
    {
        $user = Auth::user(); // Assuming you are using authentication
        return view('auth.profile.userProfile', compact('user'));
    }

    // // Handle password reset
    // public function userResetPassword(Request $request)
    // {
    //     $request->validate([
    //         'newPassword' => 'required|min:6|confirmed', // Ensure 'newPassword' matches 'newPassword_confirmation'
    //     ]);

    //     $user =Auth::user(); // Assuming you are using authentication
    //     $user->password = bcrypt($request->input('newPassword'));
    //     $user->save();

    //     return redirect()->route('user.dashboard')->with('success', 'Password reset successfully!');
    // }
    // public function userResetPassword(Request $request)
    // {      
    //     // Validate the request data
    //     $validator = Validator::make($request->all(), [
    //         'username' => 'required',
    //         'newPassword' => 'required|string|min:5|confirmed',
    //     ]);

    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // Find the staff member by username
    //     $user = Auth::where('username', $request->username)->first();

    //     if (!$user) {
    //         // Handle case where staff member is not found
    //         return redirect()->back()->withErrors(['username' => 'User member not found']);
    //     }

    //     // Update the staff member's password
    //     $user->password = Hash::make($request->newPassword);
        
    //     try {
    //         $user->save();
    //         // Redirect back with success message
    //         return redirect()->back()->with('success', 'Password reset successfully');
    //     } catch (\Exception $e) {
    //         // Handle database save error
    //         return redirect()->back()->with('error', 'Failed to reset password. Please try again.');
    //     }
    // }
    public function userResetPassword(Request $request)
    {        
        $request->validate([
            'newPassword' => 'required|min:6|confirmed', // Ensure 'newPassword' matches 'newPassword_confirmation'
        ]);
       
        $user = User::where('username', $request->username)->first();
        
        if (!$user) {
            return back()->withErrors(['username' => 'Invalid username.']);
        }
        
        $user->password = bcrypt($request->newPassword);
        $user->save();
        
        return back()->with('success', 'Password reset successfully!');
    }

}
