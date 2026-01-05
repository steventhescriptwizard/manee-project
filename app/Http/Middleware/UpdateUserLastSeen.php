<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            // Update last_seen_at every 5 minutes to avoid too many DB writes
            $user = auth()->user();
            if ($user->last_seen_at === null || $user->last_seen_at->lt(now()->subMinutes(5))) {
                $user->update(['last_seen_at' => now()]);
            }
        }

        return $next($request);
    }
}
