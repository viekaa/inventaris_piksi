<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirect user after login based on role and bidang
     */
    protected function authenticated($request, $user)
    {
        // Admin redirect
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        // Petugas redirect
        if ($user->role === 'petugas') {
            $map = [
                'Akademik' => 'akademik',
                'Keuangan' => 'keuangan',
                'Kemahasiswaan' => 'kemahasiswaan',
                'Umum' => 'umum',
            ];

            // aman kalau bidang NULL
            $bidangName = $user->bidang->nama_bidang ?? null;

            return redirect('/petugas/' . ($bidangName && isset($map[$bidangName]) ? $map[$bidangName] : 'umum'));
        }

        // default redirect
        return redirect('/home');
    }
}
