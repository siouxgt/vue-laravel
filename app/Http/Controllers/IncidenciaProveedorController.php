<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;
use App\Traits\HashIdTrait;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Carbon\Carbon;

class IncidenciaProveedorController extends Controller
{

    use HashIdTrait;

    public function __construct()
    {
        $this->middleware(['auth:proveedor', 'matrizLlena', 'verificarConstancia', 'perfilActivo']);
    }
    
    public function proveedorId()
    {
        return Auth::guard('proveedor')->user()->id;
    }

    public function index()
    {
        $urgs = Incidencia::getUrgs($this->proveedorId(), 3);
        $origenes = Incidencia::getOrigenes($this->proveedorId());
        $motivos = Incidencia::getMotivos($this->proveedorId());
        return view('proveedores.incidencias.index')->with(['urgs' => $urgs, 'totalesProveedor' => Incidencia::getTotalesUrg($this->proveedorId())[0], 'origenes' => $origenes, 'motivos' => $motivos, 'totalesAdmin' => Incidencia::getTotalesAdmin($this->proveedorId())[0]]);
    }

    public function fetchIncidencias()
    {
        $incidenciasProveedor = $this->hashEncode(Incidencia::allIncidenciasProveedor($this->proveedorId()));
        return Datatables::of($incidenciasProveedor)->toJson();
    }

    public function fetchIncidenciasAdmin()
    {
        $incidenciasAdmin = $this->hashEncode(Incidencia::allIncidenciasAdmin($this->proveedorId()));
        return Datatables::of($incidenciasAdmin)->toJson();
    }

    public function edit($id)
    { //Abre modal cerrar incidencia
        $incidencia = $this->hashEncode(Incidencia::find($this->hashDecode($id)));
        return view('proveedores.incidencias.modals.cerrar_incidencia')->with(['incidencia' => $incidencia]);
    }

    public function update(Request $request, $id)
    {
        $incidencia = Incidencia::find($this->hashDecode($id));

        $validator = Validator::make(
            $request->all(),
            [
                'fecha_cierre' => "required|date|after_or_equal:" . ($incidencia->created_at->format('Y-m-d')) . "|before_or_equal:" . now(),
                'conformidad' => 'required|in:si,no',
                'comentario' => "max:1000",
            ],
            [
                'fecha_cierre.required' => 'La fecha de cierre es necesaria.',
                'fecha_cierre.after_or_equal' => 'La fecha de cierre no puede ser una fecha menor a la de su apertura que fue el ' . $incidencia->created_at->format('d/m/Y'),
                'fecha_cierre.before_or_equal' => 'La fecha cierre no puede ser una fecha mayor a la de hoy.',
                'conformidad.required' => 'Responda si esta o no conforme con la respuesta recibida.',
                'comentario.max' => 'El comentario debe ser de un máximo de 1000 caracteres.',
            ],

        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $incidencia->fecha_cierre = $request->input('fecha_cierre');
            $incidencia->conformidad = $request->input('conformidad') == 'si' ? true : false;
            $incidencia->comentario = $request->input('comentario');
            $incidencia->estatus = false; //Incidencia cerrada
            $incidencia->update();

            return response()->json(['status' => 200, 'mensaje' => 'La incidencia fue cerrada con éxito.',]);
        }
    }
}
