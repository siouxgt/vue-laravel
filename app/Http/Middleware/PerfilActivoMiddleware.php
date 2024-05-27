<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilActivoMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        //Este middleware checara que el perfil del proveedor este activo, si el perfil del proveedor ha sido desactivado por el administrador, entonces no podra acceder a ningun lado de contrato marco para proveedor
        if (Auth::guard('proveedor')->user()->estatus) {
            return $next($request);
        } else { //Si el perfil esta inactivo, expulsar
            return redirect()->route("proveedor.logout");
        }
    }
}
