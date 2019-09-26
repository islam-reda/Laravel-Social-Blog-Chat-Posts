<?php

namespace App\Http\Middleware;

use Sentinel;
use Closure;

class AdminMiddleware
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

        if(Sentinel::check() && (Sentinel::getUser()->roles()->first()->slug == 'admin')){
            //\Log::info('role',['role'=>Sentinel::getUser()->roles()->first()->slug]);
            return $next($request);

//            if(Sentinel::getUser()->roles()->first()->slug == 'admin'){
////
//            }
        }
        else{

            return redirect('/login');
        }
    }
}
