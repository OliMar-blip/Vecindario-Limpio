<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Protección contra Clickjacking (evita que metan tu web en un iframe malicioso)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Evita que el navegador adivine tipos de archivo (MIME sniffing)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Protección clásica XSS del navegador
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Controla qué información se envía al navegar a enlaces externos
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Bloquea acceso no autorizado a cámara, micrófono o GPS desde tu web
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        return $response;
    }
}