<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Rotas públicas de autenticação
|--------------------------------------------------------------------------
*/

// Formulário de login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Processar login — throttle: 5 tentativas por minuto por IP
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');

// Logout (apenas usuários autenticados)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Rotas públicas de cadastro
|--------------------------------------------------------------------------
*/

// Formulário de cadastro público
Route::get('/register', [UserController::class, 'register'])->name('register');

// Processar cadastro (cria conta comum)
Route::post('/store', [UserController::class, 'store'])->name('users.store');

/*
|--------------------------------------------------------------------------
| Rotas de recuperação de senha (públicas)
|--------------------------------------------------------------------------
*/

Route::get('/forgot-password', [UserController::class, 'forgotPassword'])
    ->name('users.password.request');

Route::post('/forgot-password', [UserController::class, 'resetPassword'])
    ->name('users.password.reset');

/*
|--------------------------------------------------------------------------
| Página inicial (autenticados)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('auth')->name('home');

/*
|--------------------------------------------------------------------------
| Área administrativa — protegida pelo middleware 'admin'
| Visitante não autenticado  → /login
| Autenticado sem perfil admin → 403
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {

    // Listagem de usuários
    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    // Detalhes de um usuário
    Route::get('/admin/user/{user}', [UserController::class, 'show'])
        ->name('admin.users.show');

});
