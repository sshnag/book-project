<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NoCache
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (!($response instanceof BinaryFileResponse || $response instanceof StreamedResponse)) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');
        }

        return $response;
    }
}
