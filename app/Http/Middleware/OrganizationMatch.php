<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class OrganizationMatch extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // 解析
            $organization_code = $this->auth->parseToken()->getClaim('organization_code');
        } catch (JWTException $e) {
            /**
             * token解析失败，说明请求中没有可用的token。
             * 为了可以全局使用（不需要token的请求也可通过），这里让请求继续。
             * 因为这个中间件的责职只是校验token里的角色。
             */
//            return $next($request);
        }

        if(empty($organization_code)){
            $organization_code = $request->header('Organization-Code');
        }
        if(empty($organization_code)){
            return Response::json(['code'=>-10001,'message'=>'缺少机构代码'],401);
        }

        $key = $organization_code;
        //缓存
        $res = DB::connection('mysql1')->table('users','u')->where(['username'=>$organization_code])->get()->first();

        //
        if(empty($res)){
            return Response::json(['code'=>-10001,'message'=>'机构代码不正确'],401);
        }

        //确认数据库的全局连接
        Config::set('database.default',$res->nick_name);

        //todo 这里应该还要跟连接的数据库进行校对
        //*** 这里写校验的业务代码 *** //

        return $next($request);
    }
}
