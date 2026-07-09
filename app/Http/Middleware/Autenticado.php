<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Autenticado
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('usuario_id')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
