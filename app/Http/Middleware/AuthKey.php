<?php

namespace App\Http\Middleware;

use Closure;

class AuthKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->has('api_key');
        if(!$token){
            return response()->json([
                'status'=>401,
                'message'=>'Acceso no autorizado, no contiene la API KEY'
            ], 401);
        }
        if($token){
            $api_key="AbCd123";
            if($request->input('api_key')!=$api_key){
                return response()->json([
                    'status'=>401,
                    'message'=>'Acceso no autorizado, API KEY inválida'
                ], 401);
            }
        }
        return $next($request);
    }
}
