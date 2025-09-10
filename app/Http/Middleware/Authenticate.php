<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // For API requests, never redirect to a login route; return 401 JSON instead
        if ($request->expectsJson() || $request->is('api/*')) {
            return null;
        }

        // If you have a web login route, you can return it here.
        // Returning null avoids Route [login] not defined errors when no web auth exists.
        return null;
    }
}
