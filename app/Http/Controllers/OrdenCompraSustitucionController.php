<?php

namespace App\Http\Controllers;

use App\Models\OrdenCompraEstatus;
use App\Models\OrdenCompraSustitucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Traits\HashIdTrait;

class OrdenCompraSustitucionController extends Controller
{
    use HashIdTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $now = $this->obtenerFechaHoy();

        if ($id === 1) {
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'fecha_entrega_almacen' => "required|date|after_or_equal:$now",
                    'nota_remision' => 'required|mimes:pdf|max:31000',
                ],
                [
                    'fecha_entrega_almacen.required' => 'La fecha de la entrega en almacén es necesaria.',
                    'nota_remision.required' => 'Es necesario que adjunte la nota de remisión.',
                ],
            );
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            if ($id === 1) {
            } else {
                $sustitucion = OrdenCompraSustitucion::find(session('ordenCompraSustitucionId'));
                $sustitucion->fecha_entrega = \Carbon\Carbon::now();
                //-------------------------------------------------------------------------------
                if ($request->hasFile('nota_remision')) { //Comprobando si existe archivo nuevo
                    if (Storage::disk('public')->exists("proveedor/orden_compra/sustitucion/notas_remision/" . $sustitucion->nota_remision)) { //Comprobando existencia de archivo
                        Storage::disk('public')->delete("proveedor/orden_compra/sustitucion/notas_remision/" . $sustitucion->nota_remision); // Borrando archivo
                    }
                    $file = $request->file('nota_remision');
                    $nombreArchivo = time() . Str::random(8) . $file->getClientOriginalName();
                    Storage::disk('public')->put('proveedor/orden_compra/sustitucion/notas_remision/' . $nombreArchivo, File::get($file));
                    $sustitucion->archivo_nota_remision = $nombreArchivo;
                }
                //-------------------------------------------------------------------------------
                $sustitucion->update();

                $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Actualizando los estatuses
                $ordenCompraEstatus->entrega_estatus_proveedor = json_encode(['mensaje' => "Sustitución entregada", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->entrega_boton_proveedor = json_encode(['mensaje' => "Sustitución de bienes", 'css' => 'boton-verde']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "", 'css' => '']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Entrega', 'estatus' => "Entregada", 'css' => 'verde']);
                $ordenCompraEstatus->entrega_estatus_urg = json_encode(['mensaje' => "Sustitución entregada", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->entrega_boton_urg = json_encode(['mensaje' => "Aceptar pedido", 'css' => 'boton-verde']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Entrega', 'estatus' => "Entregada", 'css' => 'verde']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Sustitución entregada. Acéptala antes del " . date('d/m/Y', strtotime(' +1 day')), 'css' => 'alert-secondary']);
                $ordenCompraEstatus->update();

                return response()->json([
                    'status' => 200,
                    'mensaje' => 'Entrega registrada correctamente.',
                ]);
            }
        }
    }

    public function confirmarEnvioSustitucion(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'estatus' => "required",
            ],
            [
                'estatus.required' => 'Estatus requerido',
            ],

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            $sustitucion = OrdenCompraSustitucion::find(session('ordenCompraSustitucionId'));
            $sustitucion->fecha_envio = \Carbon\Carbon::now();
            $sustitucion->update();

            return response()->json([
                'status' => 200,
                'mensaje' => 'Envío del producto confirmado.',
            ]);
        }
    }

    public function descargarNotaRemision($archivo, $tipo = 0)
    { //Funcion que permite buscar el archivo para su visualización        
        $file = Storage::disk('public')->get($tipo == 0 ? 'proveedor/orden_compra/sustitucion/notas_remision/'  . $archivo : 'acuse-sustitucion/'  . $archivo); //Instrucciones que permiten visualizar archivo
        return  Response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $archivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
        ]);
    }

    public function obtenerFechaHoy()
    { //Funcion usada por algunos modales para evitar seleccionar fechas antiguas a hoy
        $carbon = new \Carbon\Carbon();
        $fecha_hoy = $carbon->now();
        return $fecha_hoy->format('Y-m-d');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
