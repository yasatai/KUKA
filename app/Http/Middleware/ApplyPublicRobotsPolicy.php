<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ApplyPublicRobotsPolicy
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $robots = (string) $request->attributes->get('public_robots', 'noindex, nofollow');

        $response->headers->set('X-Robots-Tag', $robots);

        return $response;
    }
}
