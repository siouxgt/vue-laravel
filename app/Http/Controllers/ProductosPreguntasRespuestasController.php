<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductosPreguntasRespuestas;
use App\Models\ProveedorFichaProducto;
use Illuminate\Support\Facades\Session;
use App\Traits\HashIdTrait;
use Carbon\Carbon;

class ProductosPreguntasRespuestasController extends Controller {
    use HashIdTrait;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'pfp_id' => 'required',
            'tema_pregunta' => "required|max:100",
            'pregunta' => "required|max:1000",
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $ppr  = new ProductosPreguntasRespuestas();
            $ppr->proveedor_ficha_producto_id = $this->hashDecode($request->input('pfp_id'));
            $ppr->urg_id = auth()->user()->urg_id;
            $ppr->tema_pregunta = $request->input('tema_pregunta');
            $ppr->pregunta = $request->input('pregunta');
            $ppr->estatus = true;
            $ppr->save();

            return response()->json(['status' => 200, 'message' => 'Tu pregunta fue enviada correctamente.',]);
        }
    }

    public function cargarPreguntasRespuestas($idPFP, $limitado = true) {
        $ppr = ProductosPreguntasRespuestas::cargarPreguntasRespuestas($this->hashDecode($idPFP), $limitado);
        $contenido = "";

        for ($i = 0; $i < count($ppr["datos"]); $i++) {
            $contenido .= " <div class='col-12'>
                                <div class='text-center vl-2 col-1'></div>                   
                                <div class='col-12' style='top: -5rem;'>
                                    <p class='text-1 font-weight-bold'>" . $ppr['datos'][$i]->tema_pregunta . "</p>
                                </div>
                
                                <div class='col-12' style='top: -4.8rem;'>
                                    <p class='text-2'>" . $ppr['datos'][$i]->pregunta . "</p>
                                </div>
                
                                <div class='col-12' style='top: -4.5rem;'>
                                    <p class='text-12 font-italic'>" . $ppr['datos'][$i]->fecha_pregunta . "</p>
                                </div>
                            </div>";
            if ($ppr['datos'][$i]->respuesta != null) {
                $contenido .= " <div class='col-12' style='top: -4rem;'>
                                    <div class='col-12'>
                                        <p class='text-2 ml-4'>" . $ppr['datos'][$i]->respuesta . "</p>
                                    </div>
                                    <div class='col-12'>
                                        <p class='text-12 font-italic ml-4'>" . $ppr['datos'][$i]->fecha_respuesta . "</p>
                                    </div>
                                </div>";
            }
        }

        if ($limitado) {
            return [
                "contenido" => $contenido,
                "total" => $ppr['total']
            ];
        } else {
            return ["ppr" => $ppr['datos']];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $datos = $this->cargarPreguntasRespuestas($id, false);
        return view('urgs.modals.preguntas_respuestas')->with($datos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        return view('proveedores.ficha_producto.modals.responder_preguntas')->with(['ppr' => ProductosPreguntasRespuestas::find($this->hashDecode($id))]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'respuesta' => "required|max:1000"
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $ppr  = ProductosPreguntasRespuestas::find($this->hashDecode($id));
            $ppr->respuesta = $request->input('respuesta');
            $ppr->update();

            //Implementar cuando las tablas hayan cambiado
            // Enviar mensaje (notificacion) de que el proveedor ya respondio la pregunta
            // $pfp = ProveedorFichaProducto::find($ppr->proveedor_ficha_producto_id);
            // $data = [
            //     'remitente' => $pfp->proveedor_id,
            //     'receptor' => $ppr->urg_id,
            //     'tipo_remitente' => 2,
            //     'tipo_receptor' => 1,
            //     'origen' => 'PREGUNTA DE PRODUCTO'
            // ];
            // return $this->storeManual($request, $data);

            return response()->json(['status' => 200, 'message' => 'La respuesta fue enviada correctamente.', 'respuesta' => $ppr->respuesta, 'fechaRespuesta' => Carbon::parse($ppr->updated_at)->format('d-m-Y')]);
        }
    }

    public function getPreguntasRespuestas($proveedorFichaProductoId){
        return [
            "contenido" => $this->hashEncode(ProductosPreguntasRespuestas::getPreguntasParaProveedor($this->hashDecode($proveedorFichaProductoId))),
        ];
    }

    public function abrirModalEnviarPreguntas() {
        return view('urgs.modals.enviar_preguntas');
    }
}
