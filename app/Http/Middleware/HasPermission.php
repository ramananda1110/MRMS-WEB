<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\permissionTrait;
class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

     use permissionTrait;

    public function handle(Request $request, Closure $next)
    {
        $this->hasPermission();
        return $next($request);


        // if(isset(auth()->user()->role->permission['name']['department']['can-list'])){
        //     return $next($request);
        // } else {
        //     abort(401);
        // }
       
    }
}
