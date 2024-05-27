<?php

namespace App\Http\Controllers;

use App\Models\OrdenCompraEstatus;
use App\Models\ProveedorComentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\HashIdTrait;

class ProveedorComentarioController extends Controller
{
    use HashIdTrait;

    public function store(Request $request)
    {
        $consultaComentarios = ProveedorComentario::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();

        if ($consultaComentarios->isEmpty()) {
            $validator = Validator::make(
                $request->all(),
                ['comentario' => "required|max:1000",]
            );

            if ($validator->fails()) {
                return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
            } else {
                $proveedorComentario = new ProveedorComentario();
                $proveedorComentario->comentario = $request->input('comentario');
                $proveedorComentario->urg_id = session()->get('urgId');
                $proveedorComentario->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
                $proveedorComentario->proveedor_id = session()->get('proveedorId');
                $proveedorComentario->save();

                $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Actualizando los estatuses
                $ordenCompraEstatus->evaluacion_estatus_proveedor = json_encode(['mensaje' => "Comentarios enviados", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->evaluacion_boton_proveedor = json_encode(['mensaje' => "Evaluación", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->evaluacion = 2;
                $ordenCompraEstatus->finalizada = 2;
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Gracias por tu evaluación. Ha concluido el proceso.", 'css' => 'alert-success']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Evaluación', 'estatus' => "Evaluada", 'css' => 'verde']);
                $ordenCompraEstatus->update();

                return response()->json(['status' => 200, 'mensaje' => 'Comentario generado correctamente.']);
            }
        } else {
            return response()->json(['status' => 400, 'errors' => ['Error' => 'Ya existen comentarios, no es posible dejar más.']]);
        }
    }
}
