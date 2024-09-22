<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomAuth extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $rows = User::find(Auth::user()->id);
            $rows->update([
                'last_login' => now()
             ]);
            return redirect()->intended('admin/dashboard')
                        ->withSuccess('Signed in');
        }

        return redirect("login")->with('email', 'Email atau Password Salah');
    }
}
