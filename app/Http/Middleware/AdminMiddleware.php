<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Accès non autorisé.'], 403);
            }
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
} 