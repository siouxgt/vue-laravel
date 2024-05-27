<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControlMatrizMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        if (Auth::guard('proveedor')->user()->perfil_completo) {
            return $next($request);
        } else {
            if (Auth::guard('proveedor')->user()->confirmacion != null) { //Ya se esta llenando la matriz pero falta confirmar el codigo enviado
                return redirect()->route("proveedor.perfil_confirmar");
            } else {//El proveedor no ha llenado matriz y por logica no tiene codigo
                return redirect()->route("proveedor.perfil_completar");
            }
        }
    }
}
