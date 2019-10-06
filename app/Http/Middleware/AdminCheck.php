<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
class AdminCheck
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
        if($var->roles_id == 1){
            return $next($request);
        }
        return redirect('/');
        
    }
}
