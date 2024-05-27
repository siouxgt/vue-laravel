<?php

namespace App\Http\Controllers;

use App\Models\AdjudicacionDirecta;
use App\Models\ContratoMarco;
use App\Models\ExpedienteContratoMarco;
use App\Models\Proveedor;
use App\Traits\ContratoTrait;
use App\Traits\ExpedienteTrait;
use App\Traits\HashIdTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ExpedientesContratoController extends Controller
{
    use HashIdTrait, ExpedienteTrait, ContratoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = $this->hashDecode(session()->get('contrato'));
        $expedientes = $this->hashEncode(ExpedienteContratoMarco::where('contrato_id', $id)->get()->sortByDesc('id'));
        $fechas = $this->fechasContrato($id);
        
        return view('admin.expediente-contrato-marco.index')->with(['expedientes' => $expedientes,'fechas' => $fechas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = $this->hashDecode(session()->get('contrato'));
        $fechas = $this->fechasContrato($id);

        return view('admin.expediente-contrato-marco.create')->with(['fechas' => $fechas]);
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

            $expediente = new ExpedienteContratoMarco;
            $expediente->f_creacion = Carbon::createFromFormat('d/m/Y',$request->input('f_creacion'));
            $expediente->metodo = $request->input('metodo');
            $expediente->num_procedimiento = $request->input('num_procedimiento');
            $expediente->contrato_id = $this->hashDecode(session()->get('contrato'));
            $expediente->user_id_creo = auth()->user()->id;
            
            if($request->file('imagen')){
                $nombre = time() . $request->file('imagen')->getClientOriginalName(); 
                Storage::disk('img_expedientes')->put($nombre, File::get($request->file('imagen')));
                $expediente->imagen = $nombre; 
            }
            $expediente->save();
            $id = $this->hashEncode($expediente);
        
            return redirect()->route('expedientes_contrato.edit',['expedientes_contrato' => $id->id_e])->with('error', 'success');
           
       } catch (\Exception $e) {
           return redirect()->back()->with('error', 'error');
       }
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
       $id = $this->hashDecode($id);

       $expediente = $this->hashEncode(ExpedienteContratoMarco::find($id));
       $proveedores = Proveedor::rfcProveedor();

       $data = ['expediente' => $expediente];
       $vista = 'admin.expediente-contrato-marco.edit';

        $contratoId = $this->hashDecode(session()->get('contrato'));
        $data += ['fechas' => $this->fechasContrato($contratoId)];
       
       switch ($expediente->metodo) {
           case "Convocatoria Directa Contrato Marco":
                $adjudicacion = $this->adjudicacionDirecta($id);
                if($adjudicacion != null ){
                    $data += $adjudicacion;
                    $vista = 'admin.expediente-contrato-marco.edit_completo';
                }
                else{
                    $data += ['proveedores' => $proveedores];
                }
            break;
            case "Convocatoria Restringida Contrato Marco":
                $invitacion = $this->invitacionRestringida($id);
                if($invitacion != null){
                    $data += $invitacion;
                    $vista = 'admin.expediente-contrato-marco.edit_completo';
                }
                else {
                    $data += ['proveedores' => $proveedores];
                }
            break;
            case "Convocatoria Pública Contrato Marco":
                $licitacion = $this->licitacionPublica($id);
                if($licitacion != null){
                    $data += $licitacion;
                    $vista = 'admin.expediente-contrato-marco.edit_completo';
                }
                else {
                    $data += ['proveedores' => $proveedores];
                }
            break;
       }

       return view($vista)->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $this->hashDecode($request->input('expediente_id'));
        try {
            $expediente = ExpedienteContratoMarco::find($id);
            $expediente->f_creacion = Carbon::createFromFormat('d/m/Y',$request->input('f_creacion'));
            $expediente->num_procedimiento = $request->input('num_procedimiento');
            if($request->file('imagen')){
                if(Storage::disk('img_expedientes')->exists($expediente->imagen)){
                    Storage::disk('img_expedientes')->delete($expediente->imagen);
                }
                $nombre = time() . $request->file('imagen')->getClientOriginalName(); 
                Storage::disk('img_expedientes')->put($nombre, File::get($request->file('imagen')));
                $expediente->imagen = $nombre; 
            }
            $expediente->update();
        
            $response = array('success' => true, 'message' => 'Expediente actualizado correctamente.');
           
       } catch (\Exception $e) {
           $response = ['success' => false, 'message' => 'Error al actualizar el expediente.'];
       }
        return $response;
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

    public function liberar($id)
    {
        $id = $this->hashDecode($id);
        $contratoId = $this->hashDecode(session('contrato'));
        $expediente = ExpedienteContratoMarco::find($id);
        if($expediente->porcentaje == 100){
            $expediente->liberado = true;
            $expediente->update();

            $countExpediente = ExpedienteContratoMarco::where('contrato_id',$contratoId)->count();
            if($countExpediente == 1){
                $this->porcentajeContrato(17,$contratoId);
                $this->seccionTerminada('expediente',$contratoId);
            }

            $response = array('success' => true, 'message' => 'Procedimiento liberado correctamente.');
        }
        else{
            $response = ['success' => false, 'message' => 'Procedimiento incompleto '. $expediente->porcentaje .'%/100%.'];
        }

        return $response;
    }

    public function filtros($tipo){
        $id = $this->hashDecode(session()->get('contrato'));
        $expedientes = $this->hashEncode(ExpedienteContratoMarco::expediente($id,$tipo));
        foreach ($expedientes as $key => $value) {
            $fecha = ExpedienteContratoMarco::fecha($value->id, $tipo);
            $expedientes[$key]->updated_at = $fecha[1];
            
        }
        $expedientes = $this->fechasDiff($expedientes);
        

        return ['success' => true, 'data' => $expedientes];
    }
}
