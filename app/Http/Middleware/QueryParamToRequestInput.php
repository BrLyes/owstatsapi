<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class QueryParamToRequestInput
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //TODO: Make this dynamic
        foreach($request->route()->parameters as $name => $value)
            $request->merge([$name => $value]);
        return $next($request);
    }
}
