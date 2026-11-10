<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profile;

class UserController extends Controller
{
    /**
     * Lista todos os usuários (painel admin).
     * GET /admin/users
     */
    public function index()
    {
        $users = User::paginate(5);

        return view('user.index', [
            'users' => $users,
            'title' => 'Lista de usuários do Sistema',
        ]);
    }

    /**
     * Exibe detalhes de um usuário (painel admin).
     * GET /admin/user/{user}
     */
    public function show(int $id)
    {
        $user = User::findOrFail($id);

        return view('user.show', ['user' => $user]);
    }

    /**
     * Exibe o formulário de cadastro público.
     * GET /register
     */
    public function register()
    {
        return view('user.create');
    }

    /**
     * Processa o cadastro de um novo usuário.
     * POST /store
     *
     * - Cadastro público  → cria conta comum (sem perfil admin) e redireciona para /login
     * - Admin autenticado → cria conta e redireciona para o painel administrativo
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create($input);

        // Cria perfil padrão 'user' — nunca 'admin' via formulário público
        Profile::create([
            'user_id'     => $user->id,
            'type'        => 'user',
            'description' => 'Usuário comum',
        ]);

        // Se um admin autenticado criou o usuário pelo painel, volta ao painel
        if (Auth::check() && Auth::user()->profile?->type === 'admin') {
            return redirect()->route('admin.users.index')
                ->with('success', 'Usuário cadastrado com sucesso!');
        }

        // Cadastro público: redireciona para login com confirmação
        return redirect()->route('login')
            ->with('success', 'Conta criada com sucesso! Faça login para continuar.');
    }

    /**
     * Exibe o formulário de recuperação de senha.
     * GET /forgot-password
     */
    public function forgotPassword()
    {
        return view('user.forgot-password');
    }

    /**
     * Processa a redefinição de senha.
     * POST /forgot-password
     */
    public function resetPassword(Request $request)
    {
        $input = $request->validate([
            'email'    => 'required|string|email|max:255|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $input['email'])->first();
        $user->password = $input['password'];
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('status', 'Senha alterada com sucesso!');
    }
}
