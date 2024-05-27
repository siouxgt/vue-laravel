<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {                
                if ($guard === 'proveedor') {                    
                    // return redirect()->route("proveedor.aip"); //Original

                    if (!Auth::guard('proveedor')->user()->perfil_completo) { //Perfil no completo
                        if (Auth::guard('proveedor')->user()->constancia == "true") {
                            if (Auth::guard('proveedor')->user()->confirmacion == "") { //Si aun no tiene codigo de confirmacion entonces no ha llenado su perfil, por lo tanto se le enviara a esa seccion                                                                       
                                return redirect()->route("proveedor.perfil_completar");
                            } else { //Si el proveedor ya lleno la matriz pero su perfil aun no esta completo, entonces esta solo en espera del codigo de confirmación
                                return redirect()->route("proveedor.perfil_confirmar");
                            }
                        } else {
                            return redirect()->route("proveedor.vencida");
                        }
                    } else {
                        return redirect()->route("proveedor.aip"); //Abrir Home (Inicio) proveedor                    
                    }
                }
            }
        }

        return $next($request);
    }
}
