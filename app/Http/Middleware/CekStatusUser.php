<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekStatusUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status !== 'aktif') {

            Auth::logout(); // paksa logout

            return redirect()->route('login')
                ->with('error', 'Akun kamu sudah dinonaktifkan');
        }

        return $next($request);
    }
}
