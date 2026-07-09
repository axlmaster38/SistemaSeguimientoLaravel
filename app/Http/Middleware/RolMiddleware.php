<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        if ($request->session()->get('rol_usuario') !== $rol) {
            return redirect()
                ->back()
                ->with('error', 'No tienes permisos para realizar esta accion.');
        }

        return $next($request);
    }
}
