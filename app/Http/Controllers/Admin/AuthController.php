<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\AdminOnlineStatusChanged;
use App\Events\UserOnlineStatusChanged;


use Inertia\Inertia;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        return Inertia::render('Admin/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'admin_email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (!Auth::guard('admin')->attempt($credentials)) {


            return response()->json(['error' => 'Invalid admin credentials'], 401);
        }

        $admin = Auth::guard('admin')->user();

        $admin->update([
            'is_online' => 1
        ]);
        broadcast(new AdminOnlineStatusChanged($admin))->toOthers();
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $admin = auth('admin')->user();

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    public function showRegister()
    {
        return Inertia::render('Admin/Register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,admin_email',
            'password' => 'required|min:6|confirmed',
        ]);

        Admin::create([
            'admin_name' => $data['name'],
            'admin_email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('admin.login');
    }
}
