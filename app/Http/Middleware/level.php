<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class level
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$_level)
    {
        $level=Auth::user()->level;
        if($level>$_level){
            return redirect()->route('dashboard')->with('warning','You don\'t have permission To view the page.');
        }
        return $next($request);
    }
}
