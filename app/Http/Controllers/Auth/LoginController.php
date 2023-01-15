<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    //
    public function authenticate(Request $request)
    {
        $remember = $request->has('remember');

        $request->validate([
            'email'         => 'required|email',
            'password'      => 'required|min:7',
        ]);

        if (auth()->guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))->with('error', 'Username Atau Password Salah');
    }
    //
    public function logout(Request $request)
    {
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
