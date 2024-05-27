<?php

namespace App\Http\Controllers;

use App\Models\ContratoMarco;
use App\Models\ExpedienteContratoMarco;
use App\Models\HabilitarProveedore;
use App\Models\Proveedor;
use App\Traits\ContratoTrait;
use App\Traits\HashIdTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class HabilitarProveedoreController extends Controller
{
    use HashIdTrait, ContratoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contratoId = $this->hashDecode(session()->get('contrato'));
        $fechas = $this->fechasContrato($contratoId);
        return view('admin.habilitar-proveedores.index')->with(['fechas' => $fechas]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HabilitarProveedore  $habilitarProveedore
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $habilitarProveedor = $this->hashEncode(HabilitarProveedore::find($id));

        return view('admin.habilitar-proveedores.modal_edit')->with(['habilitarProveedor' => $habilitarProveedor]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HabilitarProveedore  $habilitarProveedore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = $this->hashDecode($id);
        try {
            $habilitarProveedor = HabilitarProveedore::find($id);
            $fecha = $habilitarProveedor->fecha_adhesion;
            $habilitarProveedor->fecha_adhesion = $request->input('fecha_adhesion') != null ? Carbon::createFromFormat('d/m/Y',$request->input('fecha_adhesion')) : null;
            $habilitarProveedor->habilitado = $request->input('habilitado') ? 1 : 0;
            if($request->file('archivo_adhesion')){
                if(Storage::disk('contrato_adhesion')->exists($habilitarProveedor->archivo_adhesion)){
                    Storage::disk('contrato_adhesion')->delete($habilitarProveedor->archivo_adhesion);
                }
                $archivo_nombre = time() .$request->file('archivo_adhesion')->getClientOriginalName();
                Storage::disk('contrato_adhesion')->put($archivo_nombre, File::get($request->file('archivo_adhesion')));
                $habilitarProveedor->archivo_adhesion = $archivo_nombre;
            }
            $habilitarProveedor->update();

            $contratoId = $this->hashDecode(session('contrato'));
            $countProveedor = HabilitarProveedore::where('contrato_id',$contratoId)->where('habilitado',true)->count();
            if($countProveedor == 1 && $fecha == NULL){
                $this->porcentajeContrato(17,$contratoId);
                $this->seccionTerminada('proveedor',$contratoId);
            }

            $response = array('success' => true, 'message' => 'Proveedor habilitado correctamente.');
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al habilitar al proveedor.'];
        }
        return $response;
    }

    public function data(){
        $habilitarProveedores = $this->hashEncode(HabilitarProveedore::todos($this->hashDecode(session('contrato'))));
        
        $habilitarProveedores = $this->hashEncodeId($habilitarProveedores, 'proveedor_id');

        return Datatables::of($habilitarProveedores)->toJson();
    }
}
