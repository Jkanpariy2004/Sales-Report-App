<?php

namespace App\Http\Controllers\Admin\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('AdminDashboard.Pages.Login.Login');
    }

    public function Login(Request $request)
    {
        $message = [
            'email.required' => 'Please Enter Valid Email Id.',
            'password.required' => 'Please Enter Valid Password.',
            'password.min' => 'Please Enter Minimum 6 digits Password.',
        ];

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], $message);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['success' => 'Login Successful. Redirecting....'], 200);
        }

        return response()->json(['errors' => 'Please Enter Valid email or password.'], 400);
    }

    public function Logout()
    {
        Auth::guard('admin')->logout();

    }
}
