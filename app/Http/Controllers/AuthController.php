<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // GET /registro -> muestra el formulario de registro.
    public function showRegister()
    {
        return view('auth.register');
    }

    // POST /registro -> crea el usuario nuevo.
    public function register(Request $request)
    {
        $datos = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // No hace falta Hash::make() aquí: el cast 'password' => 'hashed'
        // del modelo User ya lo hashea solo al guardar.
        $user = User::create($datos);

        // Inicia sesión automáticamente nada más registrarse, para no
        // obligar al usuario a loguearse justo después de crear la cuenta.
        Auth::login($user);

        return redirect('/inicio');
    }

    // GET /login -> muestra el formulario de login.
    public function showLogin()
    {
        return view('auth.login');
    }

    // POST /login -> comprueba credenciales e inicia sesión.
    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Auth::attempt() busca el usuario por email, compara el hash de la
        // contraseña con Hash::check() por dentro, y si coincide, crea la
        // sesión. Devuelve true/false.
        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            return redirect('/inicio');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    // POST /logout -> cierra la sesión.
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
