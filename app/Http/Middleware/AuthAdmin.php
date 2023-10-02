<?php


namespace App\Http\Middleware;

use Auth;
use JWTAuth;
use Closure;

class AuthAdmin {

/**
 * Handle an incoming request.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Closure  $next
 * @return mixed
 */
public function handle($request, Closure $next) {
    try {        
        $token  = $request->header( 'Authorization' );

        if(!$token) {
            return response()->json(["status" => null , "error" => "enter token"]);
        }
        $jwt = JWTAuth::parseToken()->authenticate();
    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
        return response()->json(["status" => null , "error" => "pad token"]);
    }

    if (Auth::check() || $jwt) {
        return $next($request);
    } else {
        return response()->json(["status" => null , "error" => "Unauthorized"] );

    }
}
}
