<?php

namespace App\Http\Controllers\web;

use App\Enum\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pageLogin()
    {
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $loginData = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8'],
                'remember_me' => ['nullable'],
            ]
        );

        $remember = $request->boolean('remember_me');

        if (Auth::attempt([

            'email' => $loginData['email'],
            'password' => $loginData['password'],

        ], $remember)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role !== UserRole::ADMIN->value) {
                Auth::logout();
                return back()->withErrors(['email' => 'You do not have permission to enter.']);
            }

            return redirect()->intended('/');
        } else {
            return back()->withErrors(['email' => 'Email or password is incorrect.']);
        }
    }

    // logout

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }
}
