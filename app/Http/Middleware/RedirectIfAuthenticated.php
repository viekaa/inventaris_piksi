<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                if ($user->role === 'admin') {
                    return redirect('/admin/dashboard');
                }

                if ($user->role === 'petugas') {
                    $map = [
                        'Akademik'      => 'akademik',
                        'Keuangan'      => 'keuangan',
                        'Kemahasiswaan' => 'kemahasiswaan',
                        'Umum'          => 'umum',
                    ];
                    $bidangName = optional($user->bidang)->nama_bidang;
                    return redirect('/petugas/' . ($map[$bidangName] ?? 'umum'));
                }

                return redirect('/admin/dashboard');
            }
        }

        return $next($request);
    }
}
