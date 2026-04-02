<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        $user = Usuarios::where('usu_email', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->usu_senha)) {
            return back()->withErrors(['email' => 'Email ou senha inválidos'])->withInput();
        }

        session([
            'user_id' => $user->usu_id,
            'user_name' => $user->usu_nome,
        ]);

        return redirect()->route('dashboard');
    }

    public function showRegister()
    {
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:usuarios,usu_email'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        $user = Usuarios::create([
            'usu_nome' => $request->input('name'),
            'usu_email' => $request->input('email'),
            'usu_senha' => Hash::make($request->input('password')),
        ]);

        session([
            'user_id' => $user->usu_id,
            'user_name' => $user->usu_nome,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['user_id', 'user_name']);
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
