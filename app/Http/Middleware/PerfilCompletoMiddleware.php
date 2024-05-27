<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilCompletoMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        if (Auth::guard('proveedor')->user()->perfil_completo == false && Auth::guard('proveedor')->user()->confirmacion_fecha == null && Auth::guard('proveedor')->user()->confirmacion == null) {
            return $next($request); //se abrira la opcion de LLenar Matriz
        } else {
            return redirect()->route("proveedor.aip"); //Si la matriz ya ha sido llenada se procede a redireccionar a otro lado
        }
    }
}
