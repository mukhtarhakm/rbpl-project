<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showlogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if($user->role == 'kepsek') {
                return redirect('/dashboard/kepsek');
            } elseif ($user->role == 'bendahara') {
                return redirect('/dashboard/bendahara');
            } else {
                return redirect('/dashboard/civitas');
            }
        }

        return back()->with('error', 'Email atau password anda salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
//
}
