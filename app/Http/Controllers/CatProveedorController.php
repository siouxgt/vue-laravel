<?php

namespace App\Http\Controllers;

use App\Models\HabilitarProveedore;
use App\Models\Proveedor;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class CatProveedorController extends Controller
{
    use HashIdTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.catalogos.proveedor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.catalogos.modals.proveedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $proveedor = new Proveedor;
            $proveedor->folio_padron = $request->input('folio_padron');
            $proveedor->rfc = $request->input('rfc');
            $proveedor->constancia = $request->input('constancia');
            $proveedor->nombre = $request->input('nombre');
            $proveedor->persona = $request->input('persona');
            $proveedor->nacionalidad = $request->input('nacionalidad');
            $proveedor->mipyme = $request->input('mipyme');
            $proveedor->tipo_pyme = $request->input('tipo_pyme');
            $proveedor->codigo_postal = $request->input('codigo_postal');
            $proveedor->colonia = $request->input('colonia');
            $proveedor->alcaldia = $request->input('alcaldia');
            $proveedor->entidad_federativa = $request->input('entidad_federativa');
            $proveedor->pais = $request->input('pais');
            $proveedor->tipo_vialidad = $request->input('tipo_vialidad');
            $proveedor->vialidad = $request->input('vialidad');
            $proveedor->numero_exterior = $request->input('numero_exterior');
            $proveedor->numero_interior = $request->input('numero_interior');
            $proveedor->nombre_legal = $request->input('nombre_legal');
            $proveedor->primer_apellido_legal = $request->input('primer_apellido_legal');
            $proveedor->segundo_apellido_legal = $request->input('segundo_apellido_legal');
            $proveedor->rfc_legal = $request->input('rfc_legal');
            $proveedor->telefono_legal = $request->input('telefono_legal');
            $proveedor->extension_legal = $request->input('extension_legal');
            $proveedor->celular_legal = $request->input('celular_legal');
            $proveedor->correo_legal = $request->input('correo_legal');
            $proveedor->estatus = $request->input('estatus') ? 1 : 0;
            $proveedor->imagen = $request->input('imagen'); 
            $proveedor->acta_identidad = $request->input('acta_identidad');
            $proveedor->fecha_constitucion_identidad = $request->input('fecha_constitucion_identidad');
            $proveedor->titular_identidad = $request->input('titular_identidad');
            $proveedor->num_notaria_identidad = $request->input('num_notaria_identidad');
            $proveedor->entidad_identidad = $request->input('entidad_identidad');
            $proveedor->num_reg_identidad = $request->input('num_reg_identidad');
            $proveedor->fecha_reg_identidad = $request->input('fecha_reg_identidad');
            $proveedor->acreditacion_acta_constitutiva = $request->input('acreditacion_acta_constitutiva');
            $proveedor->num_instrumento_representante = $request->input('num_instrumento_representante');
            $proveedor->titular_representante = $request->input('titular_representante');
            $proveedor->num_notaria_representante = $request->input('num_notaria_representante');
            $proveedor->entidad_representante = $request->input('entidad_representante');
            $proveedor->num_reg_representante = $request->input('num_reg_representante');
            $proveedor->fecha_reg_representante = $request->input('fecha_reg_representante');
            $proveedor->save();
            $response = array('success' => true, 'message' => 'Proveedor guardado correctamente.');
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al guardar al proveedor.'];
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function show($id_hast)
    {
        $id = $this->hashDecode($id_hast);

        $proveedor = Proveedor::find($id);
        $proveedorHabilitado = HabilitarProveedore::proveedor($id);

        return view('admin.catalogos.proveedor.show')->with(['proveedor' => $proveedor, 'proveedorHabilitado' => $proveedorHabilitado]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function edit($id_hast)
    {
        $id = $this->hashDecode($id_hast);
        $proveedor = Proveedor::find($id);
        $proveedor = $this->hashEncode($proveedor);

        return view('admin.catalogos.modals.proveedor.edit')->with(['proveedor' => $proveedor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proveedor  $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $id = $this->hashDecode($request->input('id'));
        $proveedor = Proveedor::find($id);

        try {
            $proveedor->folio_padron = $request->input('folio_padron');
            $proveedor->rfc = $request->input('rfc');
            $proveedor->constancia = $request->input('constancia');
            $proveedor->nombre = $request->input('nombre');
            $proveedor->persona = $request->input('persona');
            $proveedor->nacionalidad = $request->input('nacionalidad');
            $proveedor->mipyme = $request->input('mipyme');
            $proveedor->tipo_pyme = $request->input('tipo_pyme');
            $proveedor->codigo_postal = $request->input('codigo_postal');
            $proveedor->colonia = $request->input('colonia');
            $proveedor->alcaldia = $request->input('alcaldia');
            $proveedor->entidad_federativa = $request->input('entidad_federativa');
            $proveedor->pais = $request->input('pais');
            $proveedor->tipo_vialidad = $request->input('tipo_vialidad');
            $proveedor->vialidad = $request->input('vialidad');
            $proveedor->numero_exterior = $request->input('numero_exterior');
            $proveedor->numero_interior = $request->input('numero_interior');
            $proveedor->nombre_legal = $request->input('nombre_legal');
            $proveedor->primer_apellido_legal = $request->input('primer_apellido_legal');
            $proveedor->segundo_apellido_legal = $request->input('segundo_apellido_legal');
            $proveedor->telefono_legal = $request->input('telefono_legal');
            $proveedor->extension_legal = $request->input('extension_legal');
            $proveedor->celular_legal = $request->input('celular_legal');
            $proveedor->correo_legal = $request->input('correo_legal');
            $proveedor->estatus = $request->input('estatus') ? 1 : 0;
            $proveedor->imagen = $request->input('imagen'); 
            $proveedor->acta_identidad = $request->input('acta_identidad');
            $proveedor->fecha_constitucion_identidad = $request->input('fecha_constitucion_identidad');
            $proveedor->titular_identidad = $request->input('titular_identidad');
            $proveedor->num_notaria_identidad = $request->input('num_notaria_identidad');
            $proveedor->entidad_identidad = $request->input('entidad_identidad');
            $proveedor->num_reg_identidad = $request->input('num_reg_identidad');
            $proveedor->fecha_reg_identidad = $request->input('fecha_reg_identidad');
            $proveedor->acreditacion_acta_constitutiva = $request->input('acreditacion_acta_constitutiva');
            $proveedor->num_instrumento_representante = $request->input('num_instrumento_representante');
            $proveedor->titular_representante = $request->input('titular_representante');
            $proveedor->num_notaria_representante = $request->input('num_notaria_representante');
            $proveedor->entidad_representante = $request->input('entidad_representante');
            $proveedor->num_reg_representante = $request->input('num_reg_representante');
            $proveedor->fecha_reg_representante = $request->input('fecha_reg_representante');
            $proveedor->update();
            $response = array('success' => true, 'message' => 'Proveedor actualizado correctamente.');
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al actualizar al proveedor.'];
        }
        return $response;
    }

    public function data()
    {
        $proveedores = $this->hashEncode(Proveedor::allProveedor());

        return Datatables::of($proveedores)->toJson();
    }

    public function buscarProveedor($rfc){
        $proveedor = Proveedor::select('id')->where('rfc',$rfc)->get();
        return $response = ['success' => true, 'data' => $proveedor];
    }
}
