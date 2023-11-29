<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckAdmin
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

      if (Session::get('UserID') == null) {
         return redirect('/')->with('error', 'Session expired')->with('class', 'danger');
      } else {
         return $next($request);
      }
   }
}
