<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            return redirect()->route('checkout.index')
                ->with('ticket_enviado', 'Solo el administrador puede acceder al panel de control.');
        }

        return $next($request);
    }
}