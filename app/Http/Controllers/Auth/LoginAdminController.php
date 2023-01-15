<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginAdminController extends Controller
{
    public function index()
    {
        return view('auth.login-admin');
    }
    //
    public function authenticate(Request $request)
    {
        $remember = $request->has('remember');

        $request->validate([
            'email'         => 'required|email',
            'password'      => 'required|min:7',
        ]);

        if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))->with('error', 'Username Atau Password Salah');
    }
    //
    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
