<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilConfirmarMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        if (Auth::guard('proveedor')->user()->perfil_completo == false && Auth::guard('proveedor')->user()->confirmacion_fecha != null && Auth::guard('proveedor')->user()->confirmacion != null) { //Si el perfil aún no está completo
            return $next($request); //Ir a la pagina que permite insertar el codigo
        } else if (Auth::guard('proveedor')->user()->perfil_completo == false && Auth::guard('proveedor')->user()->confirmacion_fecha == null && Auth::guard('proveedor')->user()->confirmacion == null) {
            return redirect()->route("proveedor.perfil_completar");
        } else {
            return redirect()->route("proveedor.aip"); //No dejar acceder a la pagina de insercion del codigo
        }
    }
}
