<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
class AdminUserCheck
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
        $var = User::findorfail(\Auth::user()->id);
        if($var->roles_id == 3){
            return redirect('/');  
        }
         return $next($request);
    }
}
