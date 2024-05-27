<?php

namespace App\Http\Controllers;

use App\Models\ContratoMarco;
use App\Models\ContratoMarcoUrg;
use App\Models\Urg;
use App\Traits\ContratoTrait;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class ContratoMarcoUrgController extends Controller
{
    use HashIdTrait, ContratoTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cmu = ContratoMarcoUrg::all();
        $contrato = ContratoMarco::find($this->hashDecode(session()->get('contrato')));
        $fechas = $this->fechasContrato($this->hashDecode(session()->get('contrato')));

        return view('admin.habilitar-contrato-marco.urg.index')->with(['fechas' => $fechas, 'contrato' => $contrato]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.habilitar-contrato-marco.modals.urg.create');
    }

    public function abrirAgregarUrg($idCM)
    {
        $idCM =  $this->hashDecode($idCM);
        
        return view('admin.habilitar-contrato-marco.modals.urg.create')->with(
            ['urgs' => $this->cargarUrgsParticipantesPurgado($idCM)]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_cm' => 'required|integer',
            'id_urg' => 'required|integer',
            'fecha_firma' => 'required|date',
            'terminos_especificos' => 'required|mimes:pdf|max:31000',
        ]);
        $contratoId = $this->hashDecode(session('contrato'));
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            $cmu = new ContratoMarcoUrg();
            $cmu->contrato_marco_id = $contratoId;
            $cmu->urg_id = $request->input('id_urg');
            $cmu->fecha_firma = $request->input('fecha_firma');
            //-------------------------------------------------------------------
            //Trabajando con archivo a guardar  
            //-------------------------------------------------------------------                      
            if ($request->hasFile('terminos_especificos')) { //Comprobando si en verdad existen archivos del usuario para proceder a subirlos      
                $cmu->a_terminos_especificos = $this->almacenarArchivos($request->file('terminos_especificos')); //Si los archivos existen se procede a guardar
            }
            //-------------------------------------------------------------------
            $cmu->numero_archivo_adhesion = $request->input('numero_archivo_adhesion');
            $cmu->estatus = true;
            $cmu->save();

            $countUrg = ContratoMarcoUrg::where('contrato_marco_id',$contratoId)->count();
            if($countUrg == 1){
               $this->porcentajeContrato(15,$contratoId);
               $this->seccionTerminada('urg',$contratoId);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Participación de URG registrada con éxito.'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $cmu = ContratoMarcoUrg::find($id);
        $urg = $this->cargarUrgs($cmu->urg_id);
        return view('admin.habilitar-contrato-marco.modals.urg.edit')->with([
            'cmu' => $cmu,
            'urg' => $urg, 
            'urgs' => $this->cargarUrgsParticipantesPurgado($cmu->contrato_marco_id)
        ]);
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
        $validator = Validator::make($request->all(), [
            'id_cmu' => 'required|integer',
            'id_cm' => 'required|integer',
            'id_urg' => 'required|integer',
            'fecha_firma' => 'required|date',
            'terminos_especificos' => [
                Rule::requiredIf($request->hasFile('terminos_especificos') ? true : false),
                "mimes:pdf",
                "max:31000"
            ]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            $cmu = ContratoMarcoUrg::find($request->input('id_cmu'));
            $cmu->urg_id = $request->input('id_urg');
            $cmu->fecha_firma = $request->input('fecha_firma');
            //-------------------------------------------------------------------
            //Trabajando con archivo a guardar  
            //-------------------------------------------------------------------                                  
            if ($request->hasFile('terminos_especificos')) { //Comprobando si en verdad existen archivos del usuario para proceder a subirlos      
                if (Storage::disk('public')->exists("cm_urg/" . $cmu->a_terminos_especificos)) { // aquí compruebo que existan los archivos anteriores
                    Storage::disk('public')->delete("cm_urg/" . $cmu->a_terminos_especificos); // Borrando archivos                    
                }
                $cmu->a_terminos_especificos = $this->almacenarArchivos($request->file('terminos_especificos')); //Si los archivos existen se procede a guardar
            }
            //-------------------------------------------------------------------
            $cmu->numero_archivo_adhesion = $request->input('numero_archivo_adhesion');
            $cmu->estatus = true;
            $cmu->update();

            return response()->json([
                'status' => 200,
                'message' => 'Participación de URG actualizada correctamente.'
            ]);
        }
    }

    public function habilitarParticipante($opcion, $id)
    { //Función que permite habilitar o inhabilitar la participación de la URG
        try {
            $cmu = ContratoMarcoUrg::find(decrypt($id));
            $opcion === 'true' ? $cmu->estatus = true : $cmu->estatus = false;
            $cmu->update();

            return response()->json([
                'status' => 200,
                'message' => ($opcion == 'true' ? "URG habilitada correctamente." : "URG inhabilitada correctamente.")
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => "No se pudo actualizar: " + $e
            ]);
        }
    }

    public function almacenarArchivos($archivo) //Funcion que permite generar nuevo nombre y guardar archivos en storage
    {
        $a_nombre_unico = time() . Str::random(15) . $archivo->getClientOriginalName(); //Asignando un nombre unico al archivo (con time) para que sea guardado
        Storage::disk('public')->put('cm_urg/' . $a_nombre_unico, File::get($archivo)); //Guardando en disco el archivo con el nuevo nombre asignado
        return $a_nombre_unico;
    }

    public function verArchivo($archivo)
    { //Funcion que permite buscar el archivo mendiante su id para su posterior visualización
        $file = Storage::disk('public')->get('cm_urg/'  . $archivo); //Instrucciones que permiten visualizar archivo
        return  Response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $archivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
        ]);
    }

    public function cargarUrgsParticipantesPurgado($idCM)
    {
        $urgsParticipando = $this->cargarUrgsParticipando($idCM);
        $urgsTodas = $this->cargarUrgs();
        $posiciones = [];
        $contador = 0;

        for ($i = 0; $i < count($urgsParticipando); $i++) {
            for ($j = 0; $j < count($urgsTodas); $j++) {
                if ($urgsParticipando[$i]->urg_id == $urgsTodas[$j]->id) {
                    $posiciones[$contador] = $j;
                    $contador++;
                }
            }
        }

        for ($k = 0; $k < count($posiciones); $k++) {
            unset($urgsTodas[$posiciones[$k]]);
        }
        $ordenado = array_values($urgsTodas);
        return $ordenado;
    }

    public function cargarUrgsParticipando($idCM)
    { //Función que buscara las Ids de las urgs que estan participando ya en el contrato marco seleccionado
        $consulta =  DB::select("SELECT urg_id
        FROM contratos_marcos_urgs
        WHERE contrato_marco_id = $idCM");
        return $consulta;
    }

    public function cargarUrgs($id = 0) //Funcion que permitira cargar las entidades administradoras (nombre URG)
    {
        $urg = Urg::cargarURGs($id);
        return $urg = $this->hashEncode($urg);
    }

    public function fetchCMU($id_cm)
    {
        $id_cm = $this->hashDecode($id_cm);
        $cmu = $this->hashEncode(ContratoMarcoUrg::allCMU($id_cm));
        if($cmu){
            foreach ($cmu as $key => $objeto) {
                $cmu[$key]->id_cmu = encrypt($cmu[$key]->id_cmu);
            }
        }
        return Datatables::of($cmu)->toJson();
    }

    public function allCMUTE($idURG) //Todos los contratos marcos tomando en cuenta el URG y sus terminos especificos en los que participa
    {
        return DB::select("SELECT u.ccg, u.nombre, cmu.fecha_firma, cmu.a_terminos_especificos, cm.nombre_cm, cm.liberado 
        FROM contratos_marcos_urgs as cmu, urgs as u, contratos_marcos as cm
        WHERE cm.id = cmu.contrato_marco_id 
        AND u.id = cmu.urg_id 
        AND u.id = $idURG"); //Mejorar con Join más adelante
    }
}
