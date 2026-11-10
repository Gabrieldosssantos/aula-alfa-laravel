<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Exibe o formulário de login.
     * GET /login
     */
    public function showLogin()
    {
        // Se já autenticado, redireciona conforme o perfil
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Processa as credenciais enviadas pelo formulário.
     * POST /login  — protegido por throttle (5 tentativas / minuto)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Auth::attempt respeita o campo 'remember' se presente
        if (Auth::attempt($credentials)) {
            // Regera o ID da sessão para prevenir session fixation
            $request->session()->regenerate();

            return $this->redirectByRole(Auth::user());
        }

        // Credencial inválida: mensagem genérica, preserva apenas o e-mail
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Credenciais inválidas. Verifique seu e-mail e senha.']);
    }

    /**
     * Encerra a sessão autenticada.
     * POST /logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalida a sessão e regenera o token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redireciona o usuário conforme seu perfil após o login.
     * Admin → /admin/users
     * Comum → /
     */
    private function redirectByRole(\App\Models\User $user)
    {
        // Carrega o profile explicitamente para garantir que não seja null
        $profile = \App\Models\Profile::where('user_id', $user->id)->first();

        if ($profile && $profile->type === 'admin') {
            return redirect()->to(route('admin.users.index'));
        }

        return redirect()->to('/');
    }
}
