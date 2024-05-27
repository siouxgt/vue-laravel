<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConstanciaVigenteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('proveedor')->user()->perfil_completo && Auth::guard('proveedor')->user()->confirmacion == null && Auth::guard('proveedor')->user()->constancia == 'true') {
            return $next($request);
        }
        return redirect()->route("proveedor.aip");        
    }
}
