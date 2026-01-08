<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Inertia\Inertia;
use App\Models\Customer;
use App\Events\CustomerOnlineStatusChanged;
use App\Events\UserOnlineStatusChanged;


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
        $customer = Auth::guard('customer')->user();

        $customer->update([
            'is_online' => 1
        ]);
        broadcast(new CustomerOnlineStatusChanged($customer))->toOthers();

        return redirect()->route('customer.dashboard');
    }

    public function logout(Request $request)
    {
        $customer = auth('customer')->user();

        Auth::guard('customer')->logout();

        if ($customer) {
            broadcast(new UserOnlineStatusChanged(
                role: 'customer',
                user_id: $customer->customer_id,
                name: $customer->customer_name,
                is_online: false
            ))->toOthers();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }


    public function showRegister()
    {
        return Inertia::render('Customer/Register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,customer_email',
            'password' => 'required|min:6|confirmed',
        ]);

        Customer::create([
            'customer_name' => $data['name'],
            'customer_email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('customer.login');
    }
}
