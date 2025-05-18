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
            'username' => 'required|string|max:20|unique:users',
            'name' => 'required|string|max:40',
            'nik' => 'required|string|max:20|unique:users',
            'alamat' => 'required|string|max:50',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:users',
            'role' => 'required|string',
        ], [
            'required' => 'Kolom tidak boleh kosong.',
            'username.unique' => 'Username ini sudah terdaftar, silakan gunakan username lain.',
            'email.unique' => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'nik.unique' => 'NIK ini sudah terdaftar, silakan gunakan NIK lain.',

        ]);

        $dummyPassword = Str::random(10);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->telepon = $request->telepon;
        $user->nik = $request->nik;
        $user->alamat = $request->alamat;
        $user->status = 'pending';
        $user->password = Hash::make($dummyPassword);
        $user->save();

        return redirect(route(name: 'login'))->with('success', 'Registrasi berhasil! Mohon tunggu verifikasi admin dalam 1x24 jam. Kami akan kirimkan password sementara ke email Anda.');
    }

    function login()
    {
        return view('auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $data = $request->only('username', 'password');
        if (Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            $user = Auth::user();
            if ($user->status == 'approved') {
                $request->session()->regenerate();
                return redirect()->route('dashboardHome');
            } else {
                Auth::logout();
                return back()->with('error', 'Akun belum diverifikasi oleh admin.');
            }
        } else {
            return back()->with('error', 'Login Gagal. NIK atau password salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    function verifikasiAkun()
    {
        $users = User::where('status', 'pending')->get();
        return view('components.verifikasiAkun', compact('users'));
    }

    function verifyUser(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $user = User::find($id);
        if ($user && $user->status == 'pending') {
            $newPassword = Str::random(10);
            $user->password = Hash::make($newPassword);
            $user->must_change_password = true;
            $user->status = $request->status;
            $user->save();

            Mail::to($user->email)->send(new SendPasswordMail($newPassword));

            session()->flash('message', [
                'title' => 'Akun berhasil diverifikasi.',
                'type' => 'success',
                'description' => $request->status === 'approved'
                    ? 'Akun berhasil diverifikasi. Password sementara telah dikirim ke email user.'
                    : 'Akun berhasil ditolak. User tidak dapat login ke sistem.'
            ]);

            return redirect(route('verifikasiAkun'));
        }
        return redirect(route('verifikasiAkun'))->with('error', 'Akun tidak ditemukan atau sudah diverifikasi sebelumnya.');
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
