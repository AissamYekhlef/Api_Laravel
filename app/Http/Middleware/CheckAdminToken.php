<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = null;
        try {
            $admin = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> returnError('INVALID_TOKEN', 'E3001');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> returnError('EXPIRED_TOKEN', 'E3001');
            } else {
                return $this -> returnError('TOKEN_NOTFOUND', 'E3001');
            }
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> returnError('INVALID_TOKEN', 'E3001');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> returnError('EXPIRED_TOKEN', 'E3001');
            } else {
                return $this -> returnError('TOKEN_NOTFOUND', 'E3001');
            }
        }

        if (!$admin)
        $this -> returnError('E401','Unauthenticated');

        return $next($request);
    }
}
