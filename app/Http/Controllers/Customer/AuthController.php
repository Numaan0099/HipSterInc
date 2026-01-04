<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Customer/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'customer_email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (!Auth::guard('customer')->attempt($credentials)) {


            return response()->json(['error' => 'Invalid customer credentials'], 401);
        }

        
        $request->session()->regenerate();

        return redirect()->route('customer.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }
}
