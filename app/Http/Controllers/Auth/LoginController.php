<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'usuario' => ['required', 'string'],
            'contrasena' => ['required', 'string'],
        ]);

        $usuario = Usuario::where('usuario', $credentials['usuario'])->first();

        if (! $usuario || ! Hash::check($credentials['contrasena'], $usuario->contrasena)) {
            return back()
                ->withErrors(['usuario' => 'Las credenciales no son válidas.'])
                ->onlyInput('usuario');
        }

        if ($usuario->estado !== 'Activo') {
            return back()
                ->withErrors(['usuario' => 'El usuario no se encuentra activo.'])
                ->onlyInput('usuario');
        }

        $request->session()->regenerate();
        $request->session()->put([
            'usuario_id' => $usuario->id,
            'nombre_usuario' => trim($usuario->nombre.' '.$usuario->apellido),
            'rol_usuario' => $usuario->rol,
        ]);

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['usuario_id', 'nombre_usuario', 'rol_usuario']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
