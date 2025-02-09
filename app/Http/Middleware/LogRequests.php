<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log the request details
        \Log::info('Requête HTTP', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'input' => $request->except(['password', 'password_confirmation']),
            'headers' => $request->headers->all(),
        ]);

        $response = $next($request);

        // Log the response status
        \Log::info('Réponse HTTP', [
            'status' => $response->status(),
            'headers' => $response->headers->all(),
        ]);

        return $response;
    }
}
