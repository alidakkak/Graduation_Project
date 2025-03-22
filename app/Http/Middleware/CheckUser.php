<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class CheckUser
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $token = $request->header('Authorization');
            $request->headers->set('auth-token', (string) $token, true);
            $request->headers->set('Authorization', 'Bearer '.$token, true);
            $user = FacadesJWTAuth::parseToken()->authenticate();
                       $auth = false;
                       foreach ($roles as $role) {
                           if (Auth::check() && $user->type == $role) {
                               $auth = true;
                           }
                       }
                       if ($auth == false) {
                           return response()->json(['Unauthorized'], 401);
                       }

        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid'])->setStatusCode(401);
            } elseif ($e instanceof TokenExpiredException) {
                return response()->json(['status' => 'Token is Expired'])->setStatusCode(401);
            } else {
                return response()->json(['status' => 'Authorization Token not found'], 401);
            }
        }

        return $next($request);
    }
}
