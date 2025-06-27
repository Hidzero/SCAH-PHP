<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Mapeamento role → padrões de rota permitidos.
     * Use '*' para liberar tudo.
     */
    protected array $permissions = [
        'master'     => ['*'],
        'admin'      => ['*'],
        'estoque'    => ['dashboard', 'estoque.*', 'profile.*'],
        'manutencao' => ['dashboard', 'manutencao.*', 'profile.*'],
        'veiculos'   => ['dashboard', 'veiculos.*', 'profile.*'],
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $role = $user->role ?? null;
        $route = $request->route()?->getName() ?? '';
        // dd($role);

        // pega o array de padrões para essa role
        $allowed = $this->permissions[$role] ?? [];

        foreach ($allowed as $pattern) {
            // converte wildcard em regex
            $regex = '^' . str_replace('\*', '.*', preg_quote($pattern, '/')) . '$';
            if (preg_match("/{$regex}/", $route)) {
                return $next($request);
            }
        }

        // se chegar aqui, não tem permissão
        abort(403, 'Acesso negado.');
    }
}
