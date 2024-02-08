<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function showLoginForm()
    {
        return view("auth.login");
    }
    function showRegisterForm()
    {
        return view("auth.register");
    }
    function store(Request $request)
    {

        $request->validate([
            "name" => "required|min:3",
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        Auth::login($user);
        return view("auth.login");
    }
    function authenticate(Request $request)
    {
        $formFields = $request->validate([
            "email" => ['required', 'email'],
            "password" => 'required'
        ]);

        if (auth()->attempt($formFields, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect('/')->with("login", 'true');
        }
        return back()->withErrors(['email' => 'Invalid Credentials'])
            ->onlyInput();
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
     }
}
