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

    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return '/admin/dashboard';
        }

        if ($user->role === 'petugas') {

            $map = [
                'Akademik' => 'akademik',
                'Keuangan' => 'keuangan',
                'Kemahasiswaan' => 'kemahasiswaan',
                'Umum' => 'umum',
            ];

            return '/petugas/' . (
                $user->bidang && isset($map[$user->bidang->nama_bidang])
                    ? $map[$user->bidang->nama_bidang]
                    : 'umum'
            );
        }

        return '/home';
    }
}
