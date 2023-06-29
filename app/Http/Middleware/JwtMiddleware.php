<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\{Request, JsonResponse};
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {

        try{
            JWTAuth::parseToken()->authenticate();
        }catch(Exception $e){

            if($e instanceof TokenInvalidException){
                return response()->json(
                    [
                        'status' => 'Invalid Token'
                    ],
                    401
                );
            }

            if($e instanceof TokenExpiredException){
                return response()->json(
                    [
                        'status' => 'Expired Token'
                    ],
                    401
                );
            }

            return response()->json(
                [
                    'status' => 'Token not found'
                ],
                401
            );
        }

        return $next($request);
    }
}
