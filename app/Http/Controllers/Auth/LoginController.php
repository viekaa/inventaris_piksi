<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

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

        // ⛔ JANGAN KE /home LAGI
        return redirect('/admin/dashboard');
    }
}
