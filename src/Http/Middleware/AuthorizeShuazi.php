<?php

namespace Haxibiao\Nova\Http\Middleware;

use Haxibiao\Nova\ShuaziViewer;

class AuthorizeShuazi
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(ShuaziViewer::class)->authorize($request) ? $next($request) : abort(403);

    }
}
