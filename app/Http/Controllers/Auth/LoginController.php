<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // ⛔ HAPUS /home, ganti ke dashboard default
    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

   protected function authenticated($request, $user)
{
    // ❌ CEK STATUS DULU
    if ($user->status !== 'aktif') {
        Auth::logout(); // paksa logout

        Alert::error('Akses ditolak', 'Akun kamu sudah dinonaktifkan');

        return redirect()->route('login');
    }

    // ✅ ADMIN
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    // ✅ PETUGAS
    if ($user->role === 'petugas') {
        $map = [
            'Akademik' => 'akademik',
            'Keuangan' => 'keuangan',
            'Kemahasiswaan' => 'kemahasiswaan',
            'Umum' => 'umum',
        ];

        $bidangName = optional($user->bidang)->nama_bidang;

        return redirect('/petugas/' . ($map[$bidangName] ?? 'umum'));
    }

    // fallback
    return redirect('/admin/dashboard');
}
}
