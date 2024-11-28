<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    public function handle(Request $request, Closure $next)
{
    $token = env('API_TOKEN');
    $requestToken = $request->input('token');


   
    if ($requestToken !== $token) {
        return response()->json(['message' => 'Acceso denegado'], 401);
    }

    return $next($request);
}

}
