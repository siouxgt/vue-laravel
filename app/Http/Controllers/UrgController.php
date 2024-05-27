<?php

namespace App\Http\Controllers;

use App\Models\Urg;
use App\Models\User;
use App\Models\ValidacionesTecnicas;
use App\Traits\HashIdTrait;
use App\Traits\PersonalTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;


class UrgController extends Controller
{
    use HashIdTrait, PersonalTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.catalogos.urg.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.catalogos.modals.urg.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validador de los valores URG
        $validator = Validator::make($request->all(), [
            'ccg' => 'required|max:100',
            'tipo' => 'required|numeric|between:1,5', //Es un combobox: Me esta enviando un numero
            'nombre' => 'required|max:150',
            'direccion' => 'required|max:250',
            'fecha_adhesion' => 'required|date',
            'archivo' => 'required|mimes:pdf|max:31000',
            'monto_actuacion' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            try {
                $urg = new Urg;
                $urg->ccg = $request->input('ccg');
                $urg->tipo = $request->input('tipo');
                $urg->nombre = $request->input('nombre');
                $urg->direccion = $request->input('direccion');
                $urg->fecha_adhesion = $request->input('fecha_adhesion');
                //-------------------------------------------------------------------------------
                $file = $request->file('archivo');
                if ($file) { //Comprobando si existe archivo en espera
                    $archivo_nombre = time() . Str::random(15) . $file->getClientOriginalName();
                    Storage::disk('public')->put('urgs' . "/" . $archivo_nombre, File::get($file));
                    $urg->archivo = $archivo_nombre;
                }
                //-------------------------------------------------------------------------------
                $urg->validadora = $request->input('validadora')? 1 : 0;
                $urg->estatus = $request->input('estatus')? 1 : 0;
                $urg->monto_actuacion = $request->input('monto_actuacion');
                $urg->save();

                if($request->input('validadora')){
                    $validacion = new ValidacionesTecnicas;
                    $validacion->urg_id = $urg->id;
                    $validacion->estatus = false;
                    $validacion->save();
                }
                $response = array('status' => 200, 'message' => 'URG registrado con éxito.');
            } catch (\Exception $e) {
                $response = array('status' => 400, 'message' => 'Error al guardar la URG.');
                Log::error('Urg registro: '. __METHOD__." ". __LINE__." ".$e->getMessage());
            }
            
            return $response;
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
        //En algunos casos, al id le incluyo un espacio en blanco al final, por lo tanto primero compruebo si ese id trae ese espacio vacio al final
        $lastChar = substr($id, -1); //Capturando el ultimo caracter del ID para hacer comparaciones mas adelante

        //COmprobando si el ultimo caracter es un espacio vacio, si el espacio es vacio entonces significa que se va a descargar un archivo
        if (strpos($lastChar, ' ') !== false) { //Entrada para descarga de archivos
            $cadena = substr($id, 0, -1); //Quitando el espacio vacio
            if (!is_numeric($cadena)) { //Comprobando si el ID es númerico o si viene hasheado (cadena de caracteres).
                $id = $this->hashDecode($cadena); //Si el ID viene hasheado se procede a decodificar
            } else {
                $id = $cadena;
            }
            $dl = Urg::find($id); //Buscando el nombre del archivo por medio de su ID para su posterior descarga
            $file = Storage::disk('public')->get("urgs/" . $dl->archivo);
            return  Response($file, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $dl->archivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
            ]);
        } else { //Entrada para ver más información del URG
            //Ya no está en función
            // $id = $this->hashDecode($id);
            // $urg = Urg::find($id);
            // $urg = $this->hashEncode($urg);
            // $tipoUrg = [
            //     "DEPENDENCIA",
            //     "ÓRGANO DESCONCENTRADO",
            //     "ADMINISTRACIÓN PARAESTATAL",
            //     "ALCALDÍA",
            //     "ORGANISMO AUTÓNOMO"
            // ];
            // $urg->tipo = $tipoUrg[($urg->tipo) - 1];
            // $urg->responsable = json_decode($urg->responsable);
            // return view('admin.catalogos.urg.show')->with([
            //     'urg' => $urg,
            //     'cmu' => $this->allCMUTE($id),
            // ]);
        }
    }

    public function verShow($id, $estatus = false)
    {
        //Entrada para ver más información del URG
        $id = $this->hashDecode($id);
        $urg = Urg::find($id);
        $urg = $this->hashEncode($urg);
        $tipoUrg = [
            "DEPENDENCIA",
            "ÓRGANO DESCONCENTRADO",
            "ADMINISTRACIÓN PARAESTATAL",
            "ALCALDÍA",
            "ORGANISMO AUTÓNOMO"
        ];
        $urg->tipo = $tipoUrg[($urg->tipo) - 1];
        $responsables = User::userResponsables($urg->id);
        // $urg->responsable = json_decode($urg->responsable);
        return view('admin.catalogos.urg.show')->with([
            'urg' => $urg,
            'cmu' => $this->allCMUTE($id),
            'el_estatus' => $estatus,
            'responsables' => $responsables
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_hast)
    {
        $id = $this->hashDecode($id_hast);
        $urg = Urg::find($id);
        $urg = $this->hashEncode($urg);
        $urg->responsable = json_decode($urg->responsable);
        return view('admin.catalogos.modals.urg.edit')->with([
            'urg' => $urg
        ]);
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
        try {
            $id = $this->hashDecode($id);
            $urg = Urg::find($id); //El ID lo estoy recibiendo de la URL enviada
            $urg->ccg = $request->input('ccg');
            $urg->tipo = $request->input('tipo');
            $urg->nombre = $request->input('nombre');
            $urg->direccion = $request->input('direccion');
            $urg->fecha_adhesion = $request->input('fecha_adhesion');

            //-------------------------------------------------------------------------------
            if ($request->hasFile('archivo')) { //Comprobando si existe archivo nuevo
                if (Storage::disk('public')->exists("urgs/" . $urg->archivo)) { //Comprobando existencia de archivo
                    Storage::disk('public')->delete("urgs/" . $urg->archivo); // Borrando archivo
                }
                $file = $request->file('archivo');
                $archivo_nombre = time() . Str::random(15) . $file->getClientOriginalName();
                Storage::disk('public')->put('urgs' . "/" . $archivo_nombre, File::get($file));
                $urg->archivo = $archivo_nombre;
            }
            //-------------------------------------------------------------------------------

            $urg->validadora = $request->input('validadora')? 1 : 0;
            $urg->estatus = $request->input('estatus')? 1 : 0;
            $urg->monto_actuacion = $request->input('monto_actuacion');
            $urg->update();

            
            $validadora = ValidacionesTecnicas::where('urg_id',$urg->id)->get();
            
            if($validadora->isEmpty()){
                $validacion = new ValidacionesTecnicas;
                $validacion->urg_id = $urg->id;
                $validacion->estatus = false;
                $validacion->save();
            }
            else{
                $validadora[0]->estatus = $request->input('validadora')? 1 : 0;
                $validadora[0]->update();
            }


            $response = array('success' => true, 'message' => 'URG actualizado con éxito.', 'datos' => $urg);
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al actualizar URG.'];
            Log::error('Urg registro: '. __METHOD__." ". __LINE__." ".$e->getMessage());
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

    public function fetchurgs()
    {
        $urgs = Urg::allURG();
        $urgs = $this->hashEncode($urgs);
        return Datatables::of($urgs)->toJson();
    }

    public function allCMUTE($idURG) //Todos los contratos marcos tomando en cuenta el URG y sus terminos especificos en los que participa
    {
        $consulta = DB::select("SELECT u.ccg, u.nombre, cmu.fecha_firma, cmu.a_terminos_especificos, cm.nombre_cm, cm.liberado 
        FROM contratos_marcos_urgs as cmu, urgs as u, contratos_marcos as cm
        WHERE cm.id = cmu.contrato_marco_id 
        AND u.id = cmu.urg_id 
        AND u.id = $idURG"); //Mejorar con Join más adelante
        return $consulta;
    }

    public function apiUrg(){
         $urgs = Urg::select(DB::raw( 'id, (ccg || \' - \' ||nombre) AS nombre'))->get();
        if($urgs->isNotEmpty()){
            $response = ['status' => 'success', 'code' => 200, 'data' => $urgs];
        }
        else {
            $response = ['status' => 'success', 'code' => 200, 'data' => 'Sin URG'];
        }

        return $response;
    }

     public function buscarUrg($ccg){
        $urg = Urg::select('id')->where('ccg',strtoupper($ccg))->get();
        return $response = ['success' => true, 'data' => $urg];
    }
}
