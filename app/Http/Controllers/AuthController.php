<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required|in:admin,pengguna',
        ]);

        // 'role' ikut dicocokkan dengan kolom role di database
        if (Auth::attempt($data, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('buku.index');
        }

        return back()
            ->withErrors(['email' => 'Email, password, atau peran tidak sesuai.'])
            ->onlyInput('email', 'role');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'role'     => 'pengguna', // pendaftar selalu pengguna
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('buku.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}