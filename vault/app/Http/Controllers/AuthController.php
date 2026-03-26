<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
 public function showRegisterForm()

   {
    return view('auth.register');

       }


public function register(Request $request)
{
    $request->validate([
        'name' => ['required', 'string' , 'max:255'],
        'email' => ['required','email', 'max:255', 'unique:users'],
        'password' => ['required', 'string','min:8','confirmed'], 
    ]);

    $user = User::create([
        'name'=> $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    Auth::login($user);

    return redirect()->route('dashboard');

    }
public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect ('/login');
        }
    }

