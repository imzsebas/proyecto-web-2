<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de inicio de sesión
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Manejar una solicitud de inicio de sesión.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intentar autenticar con email
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Si no funciona con email, intentar con username
        if (Auth::attempt(['username' => $credentials['email'], 'password' => $credentials['password']], $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Si ambos fallan, devolver con error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput($request->except('password'));
    }

    /**
     * Cerrar la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}