<?php

namespace App\Http\Controllers;

use App\Mail\SendPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    function register()
    {
        return view('auth.register');
    }

    function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:40',
            'nik' => 'required|string|max:20|unique:users',
            'alamat' => 'required|string|max:50',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:users',
            'role' => 'required|string',
            'telepon' => 'required|string',
        ], [
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'nik.unique' => 'NIK ini sudah terdaftar, silakan gunakan NIK lain.',
        ]);

        $dummyPassword = Str::random(10);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->telepon = $request->telepon;
        $user->nik = $request->nik;
        $user->alamat = $request->alamat;
        $user->is_verified = false;
        $user->password = Hash::make($dummyPassword);
        $user->save();

        return redirect(route(name: 'login'))->with('success', 'Registrasi berhasil! Mohon tunggu verifikasi admin dalam 1x24 jam.');
    }

    function login()
    {
        return view('auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $data = $request->only('email', 'password');
        if (Auth::attempt(credentials: $data)) {
            $user = Auth::user();
            if ($user->is_verified) {
                $request->session()->regenerate();
                return redirect()->route('dashboardHome');
            } else {
                Auth::logout();
                return back()->with('error', 'Akun belum diverifikasi oleh admin.');
            }
        } else {
            return back()->with('error', 'Login Gagal. Email atau password salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    function verifikasiAkun()
    {
        $users = User::where('is_verified', false)->get();
        return view('dashboard.verifikasiAkun', compact('users'));
    }

    function verifyUser($id)
    {
        $user = User::find($id);
        if (!$user->is_verified) {
            $newPassword = Str::random(10);
            $user->password = Hash::make($newPassword);
            $user->must_change_password = true;
            $user->is_verified = true;
            $user->save();

            Mail::to($user->email)->send(new SendPasswordMail(@$newPassword));
        }
        return redirect(route('verifikasiAkun'))->with('success', 'User berhasil diverifikasi.');
    }


    public function updatePassword(Request $request)
    {

        $user = Auth::user();
        $user->password = Hash::make($request->newPassword);
        $user->must_change_password = false;
        $user->save();

        return redirect(route('dashboardHome'))->with('success', 'Password berhasil diperbarui!');
    }
}
