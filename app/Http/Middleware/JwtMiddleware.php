<?php

    namespace App\Http\Middleware;

    use Closure;
    use Exception;
    use JWTAuth;
    use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

    class JwtMiddleware extends BaseMiddleware
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
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(["status" => 0,'message' => 'Token is Invalid',"data" => json_decode("{}"),]);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return response()->json(["status" => 0,'messsage' => 'Token is Expired',"data" => json_decode("{}"),]);
                }else{
                    return response()->json(["status" => 0,"message" => "Autherization token not found","data" => json_decode("{}"),]);
                }
            }

            return $next($request);
        }
    }
