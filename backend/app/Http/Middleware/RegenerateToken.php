<?php

namespace App\Http\Middleware;

use Closure;

class RegenerateToken
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
    if ($request->method() !== 'GET'){
      $request->session()->regenerateToken();
    }

    return $next($request);
  }
}
