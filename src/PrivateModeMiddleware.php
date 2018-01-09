<?php
/****
 * Register in middleware !!
 *
 * Use it when you do not want to be seen by other people, such as during development.
 * Simply enter the password written in the .env file and login.
 */
namespace Kaoken\Laravel5PrivateMode;

use Cache;
use Closure;
use Validator;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Symfony\Component\HttpFoundation\IpUtils;

class PrivateModeMiddleware extends BaseVerifier
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
        if( env('APP_ENV')=='testing')return $next($request);
        if( env('PRIVATE_MODE_VALID', true)){
            $sessionKey = 'session.kaoken.private.mode';
            $cacheKey = 'cache.kaoken.private.mode';
            $ip = $request->ip();
            $ipInfo = null;
            if( Cache::has($cacheKey) ){
                $ipInfo = Cache::get($cacheKey);
            }
            $strIP = env('PRIVATE_MODE_IP','192.168.0.1/24');
            if( !is_null($ipInfo) ){
                if( $ipInfo->env !== $strIP)
                    $ipInfo = null;
            }
            if( is_null($ipInfo) ) {
                $ipInfo = new \stdClass();
                $ipInfo->env = env('PRIVATE_MODE_IP','192.168.0.1/24');
                $strIP = preg_replace("/\s|　/", "", $strIP );
                $a = preg_split("/,/", $strIP);
                $ipInfo->ips = $a;
                Cache::put($cacheKey, $ipInfo);
            }
            if( IpUtils::checkIp($ip, $ipInfo->ips)){
                return $next($request);
            };

            $isLogin = env('PRIVATE_MODE_LOGIN_FORM',false);
            if (
                ($this->isReading($request) ||
                    $this->runningUnitTests() ||
                    $this->inExceptArray($request) ||
                    $this->tokensMatch($request)) && $isLogin
            ) {
                if( !session()->has($sessionKey) ){
                    if($request->getMethod() == 'POST'){
                        $all = $request->all();
                        $validator = Validator::make($all,[
                            'password' => 'required|between:6,32'
                        ]);

                        if ($validator->fails()) {
                            return new Response(view('vendor.private_mode.login',['errors'=>$validator->errors()->all()]));
                        }

                        if( $all['password'] == env('PRIVATE_MODE_PASSWORD', md5(rand().''))){
                            session([$sessionKey => true]);
                            return redirect('/');
                        }else{
                            return new Response(view('vendor.private_mode.login',['errors'=>['Passwords do not match.']]));
                        }
                    }
                    return new Response(view('vendor.private_mode.login',['errors'=>[]]));
                }else{
                    return $next($request);
                }
            }
            return new Response(view('vendor.private_mode.503'));
        }

        return $next($request);
    }
}