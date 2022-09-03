<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * @param $request
     * @param Closure $next
     * @param ...$guards
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     * @author zzp
     * @date 2022/9/2
     */
    public function handle($request, Closure $next, ...$guards)
    {
        return parent::handle($request, $next, $guards);
    }
}
