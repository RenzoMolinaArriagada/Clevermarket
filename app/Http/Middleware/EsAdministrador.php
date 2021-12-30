<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EsAdministrador
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
        if(Auth::check()){
            if(Auth::user()->perfil == 1 || Auth::user()->perfil == 2){
                return $next($request);
            }
            else{
                return redirect()->route('home');
            }
        }
        else{
            return redirect()->route('home');
        }
    }

}
