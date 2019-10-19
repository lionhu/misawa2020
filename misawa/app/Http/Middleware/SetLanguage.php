<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;

class SetLanguage
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
        App::setLocale(Session::get('lang')?Session::get('lang'):config('app.locale'));
        return $next($request);
    }

}
