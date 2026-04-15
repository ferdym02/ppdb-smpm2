<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Auth\Events\Registered;

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
        $profilSekolah = ProfilSekolah::first();
        return view('auth.user_login', compact('title', 'profilSekolah'));
    }

    public function userLogin(Request $request)
    {
        // ================= VALIDASI =================
        $request->validate([
            'email' => 'required|email',
            'password'  => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email'    => 'Format email tidak valid',
            'password.required'  => 'Password wajib diisi',
        ]);

        $userExists = User::where('email', $request->email)->exists();
        if (!$userExists) {
            return back()->with('error', 'Akun dengan email tersebut belum terdaftar.')->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            if ($role == 'user') {
                return redirect()->back()->with('successLogin', 'Login berhasil, Anda akan diarahkan ke dashboard.');
            } else {
                Auth::logout();
                return back()->with('error', 'Login failed!')->withInput();
            }
        }

        // Jika kredensial salah, redirect kembali dengan error message
        return back()->with('loginError', 'Email atau password salah')->withInput();
    }


    public function showRegisterForm()
    {
        $title = "Register";
        $profilSekolah = ProfilSekolah::first();
        return view('auth.user_register', compact('title', 'profilSekolah'));
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

            // Buat user baru
            $user = User::create($validatedData);

            // Kirim email verifikasi
            event(new Registered($user));

            // Login user agar bisa diarahkan ke email/verify
            auth()->login($user);

            // Redirect ke halaman verifikasi email
            return redirect()->route('verification.notice');

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

    public function showForgotPasswordForm()
    {
        $title = 'Lupa Password';
        $profilSekolah = ProfilSekolah::first();

        return view('auth.forgot-password', compact('title', 'profilSekolah'));
    }

    public function sendResetLink(Request $request)
    {
        $customMessage = [
            'email.required'    => 'Email tidak boleh kosong',
            'email.email'       => 'Email tidak valid',
            'email.exists'      => 'Email tidak terdaftar di database',
        ];

        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], $customMessage);

        $token = \Str::random(60);

        PasswordResetToken::updateOrCreate(
            [
                'email' => $request->email
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]
        );

        Mail::to($request->email)->send(new ResetPasswordMail($token));

        return redirect()->route('forgot.password')->with('success', 'Kami telah mengirimkan link reset password ke email Anda, silakan buka inbox email anda.');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        $title = 'Reset Password';
        $getToken = PasswordResetToken::where('token', $token)->first();
        $profilSekolah = ProfilSekolah::first();

        if (!$getToken) {
            return redirect()->route('user.login')->with('failed', 'Token tidak valid');
        }

        return view('auth.validasi-token', compact('token', 'title', 'profilSekolah'));
    }

    public function resetPassword(Request $request)
    {

        $customMessage = [
            'password.required' => 'Password tidak boleh kosong',
            'password.min'      => 'Password minimal 8 karakter',
        ];

        $request->validate([
            'password' => 'required|min:8|confirmed'
        ], $customMessage);

        $token = PasswordResetToken::where('token', $request->token)->first();

        if (!$token) {
            return redirect()->route('user.login')->with('failed', 'Token tidak valid');
        }

        $user = User::where('email', $token->email)->first();

        if (!$user) {
            return redirect()->route('user.login')->with('failed', 'Email tidak terdaftar di database');
        }

        // Pastikan update langsung pada objek user yang ditemukan
        $user->password = Hash::make($request->password);
        $user->save();

        $token->delete();

        return redirect()->route('user.login')->with('success', 'Password berhasil direset');
    }
}
