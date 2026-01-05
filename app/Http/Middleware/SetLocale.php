<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from settings, default to 'en'
        $locale = setting('app_locale', 'en');
        
        // Validate locale (only allow 'en' or 'id')
        if (!in_array($locale, ['en', 'id'])) {
            $locale = 'en';
        }
        
        // Set application locale
        app()->setLocale($locale);
        
        return $next($request);
    }
}
