<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function adminLoginForm()
    {
        return view('auth.admin_login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if ($role == 'admin' || $role == 'superadmin') {
                return redirect()->intended('admin/dashboard');
            } else {
                return back()->with('error', 'Login gagal!');
            }
        }

        return back()->with('error', 'Login gagal!')->withInput();
    }

    public function userLoginForm()
    {
        $title = "Login";
        return view('auth.user_login', compact('title'));
    }

    public function userLogin(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'pass'  => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email'    => 'Format email tidak valid',
            'pass.required'  => 'Password wajib diisi',
        ]);

        $credentials = [
            'email'    => $request->email,
            'password' => $request->pass,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('user.dashboard')
                ->with('success', 'Login berhasil');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->withInput();
    }

    public function showRegisterForm()
    {
        $title = "Register";
        return view('auth.user_register', compact('title'));
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        try {
            $validatedData['password'] = Hash::make($validatedData['password']);

            User::create($validatedData);

            return redirect()->back()->with('success', 'Berhasil daftar akun, silakan login.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendaftar akun. Silakan coba lagi.')->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
