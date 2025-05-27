<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckAuth
{
    public function handle(Request $request, Closure $next): mixed
    {
        $prefix = config('session.prefix');
        $id_user = Session::get("{$prefix}_id_user");

        if (!$id_user) {
            return redirect('/login')->with('error', 'Silahkan login terlebih dahulu!');
        }

        return $next($request);
    }
}
