<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Protege as rotas sob /admin/*.
     *
     * - Visitante não autenticado  → redireciona para /login (preserva destino).
     * - Autenticado sem perfil admin → 403 Forbidden.
     * - Autenticado com profile.type = 'admin' → prossegue.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Não autenticado: redireciona para login e preserva a URL pretendida
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Faça login para acessar esta área.');
        }

        // 2. Autenticado mas sem perfil administrativo → 403
        $profile = Auth::user()->profile;

        if (! $profile || $profile->type !== 'admin') {
            abort(403, 'Acesso restrito à área administrativa.');
        }

        // 3. Admin confirmado → continua
        return $next($request);
    }
}
