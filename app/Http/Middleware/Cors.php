<?php

// app/Http/Middleware/Cors.php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, DELETE, PUT')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}
