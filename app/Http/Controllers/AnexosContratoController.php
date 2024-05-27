<?php

namespace App\Http\Controllers;

use App\Models\AnexosContratoMarco;
use App\Models\ContratoMarco;
use App\Traits\ContratoTrait;
use App\Traits\HashIdTrait;
use App\Traits\SessionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\Datatables\Datatables;

class AnexosContratoController extends Controller {
    use HashIdTrait, ContratoTrait, SessionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.contrato-marco.create_anexos')->with(['id_contrato_marco' => session()->get('contrato'), 'fechas' => (session()->get('contrato') != null) ? $this->fechasContrato($this->hashDecode(session()->get('contrato'))) : '']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.contrato-marco.modals.create_anexos')->with([
            'anexos_disponibles' => $this->obtenerDocumentosDisponibles($this->hashDecode(session()->get('contrato')))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $documentosDisponibles = $this->obtenerDocumentosDisponibles($this->hashDecode(session()->get('contrato')));
        $documentosDisponibles = implode(",", $documentosDisponibles);

        $validator = Validator::make(
            $request->all(),
            [
                'nombre_documento' => "required|in:$documentosDisponibles",
                'archivo_original' => 'required|mimes:pdf|max:30720',
                'archivo_publico' => 'required|mimes:pdf|max:30720',
            ],
            [
                'archivo_original.max' => 'El documento original no debe pesar más de 32MB!',
                'archivo_publico.max' => 'El documento público no debe pesar más de 32MB!',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $contratoId = $this->hashDecode(session()->get('contrato'));
            $acm = new AnexosContratoMarco();
            $acm->contrato_marco_id = $contratoId;
            $acm->nombre_documento = $request->input('nombre_documento');
            //-------------------------------------------------------------------
            //Trabajando con los archivos a guardar
            $fao = $request->file('archivo_original');
            $fap = $request->file('archivo_publico');
            if ($fao && $fap) { //Comprobando si en verdad existen archivos del usuario para guardar
                $acm->archivo_original = $this->manejoArchivos($fao); //Si los archivos existen se procede a guardar
                $acm->archivo_publico = $this->manejoArchivos($fap);
            }
            //-------------------------------------------------------------------
            $acm->save();
            $countAnexos = AnexosContratoMarco::where('contrato_marco_id', $contratoId)->count();
            
            if ($countAnexos == 6) {
                $this->porcentajeContrato(7, $contratoId);
                $this->seccionTerminada('alta', $contratoId);
            }

            return response()->json(['status' => 200, 'message' => 'Anexo de contrato marco registrado correctamente.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return view('admin.contrato-marco.edit_anexos');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) { //Abre modal para edicion de los anexos (documentos) del contrato
        $anexos = $this->hashEncode(AnexosContratoMarco::find($this->hashDecode($id)));
        $anexos->archivo_original = substr($anexos->archivo_original, 25, strlen($anexos->archivo_original));
        $anexos->archivo_publico = substr($anexos->archivo_publico, 25, strlen($anexos->archivo_publico));
        $documentosDisponibles[] = $anexos->nombre_documento;
        $documentosDisponibles = array_merge($documentosDisponibles, $this->obtenerDocumentosDisponibles($this->hashDecode(session()->get('contrato'))));
        $this->crearSession(['anexoId' => $anexos->id_e]);
        return view('admin.contrato-marco.modals.edit_anexos')->with(['acm' => $anexos, 'documentos_disponibles' => $documentosDisponibles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $acm = AnexosContratoMarco::find($this->hashDecode(session()->get('anexoId')));
        $documentosDisponibles[] = $acm->nombre_documento;
        $documentosDisponibles = array_merge($documentosDisponibles, $this->obtenerDocumentosDisponibles($this->hashDecode(session()->get('contrato'))));
        $documentosDisponibles = implode(",", $documentosDisponibles);

        $reglaAO = ($request->hasFile('archivo_original') ? '|mimes:pdf' : '');
        $reglaAP = ($request->hasFile('archivo_publico') ? '|mimes:pdf' : '');

        $validator = Validator::make(
            $request->all(),
            [
                'nombre_documento' => "required|in:$documentosDisponibles",
                'archivo_original' => "max:30720$reglaAO", //max = 30MegaBytes => (1024 * 30 = 30720)
                'archivo_publico' => "max:30720$reglaAP",
            ],
            [
                'archivo_original.max' => 'El documento original no debe pesar más de 32MB!',
                'archivo_publico.max' => 'El documento público no debe pesar más de 32MB!',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $acm->contrato_marco_id = $this->hashDecode(session()->get('contrato'));
            $acm->nombre_documento = $request->input('nombre_documento');
            //-------------------------------------------------------------------
            //Trabajando con los archivos a guardar  
            if ($request->hasFile('archivo_original')) {
                $fao = $request->file('archivo_original');
                if (Storage::disk('public')->exists("anexos_contrato/" . $acm->archivo_original)) {
                    Storage::disk('public')->delete("anexos_contrato/" . $acm->archivo_original);
                }
                $acm->archivo_original = $this->manejoArchivos($fao); //Si los archivos existen se procede a guardar
            }
            if ($request->hasFile('archivo_publico')) { //Comprobando si en verdad existen archivos del usuario para proceder a actulizarlos
                $fap = $request->file('archivo_publico'); //Capturando el nuevo archivo que subio el usuario
                if (Storage::disk('public')->exists("anexos_contrato/" . $acm->archivo_publico)) { // aquí compruebo que exista el archivo anterior guardado en el disco
                    Storage::disk('public')->delete("anexos_contrato/" . $acm->archivo_publico); // Borrando archivo guardado en el disco                    
                }
                $acm->archivo_publico = $this->manejoArchivos($fap); //Enviando el nuevo archivo a su variable de guardado
            }
            //-------------------------------------------------------------------
            $acm->update();
            return response()->json(['status' => 200, 'message' => 'Anexo de contrato marco actualizado correctamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    protected function obtenerDocumentosDisponibles($id) {
        $anexosRegistrados = AnexosContratoMarco::registradosPorContrato($id);
        $docOriginal = ["Estudio de demanda", "Estudio de mercado (opcional)", "Oficio de inicio de Contrato Marco", "Modelo de Contrato Marco", "Terminos generales Contrato Marco", "Terminos específicos", "Creación de Contrato Marco"];
        $docGuardados = [];

        for ($key = 0; $key < count($anexosRegistrados); $key++) {
            $docGuardados[$key] = $anexosRegistrados[$key]->nombre_documento;
        }

        $array = array_values(array_diff($docOriginal, $docGuardados));
        array_push($array, 'Otro');
        return $array;
    }

    public function modalAnexos($id) { //LLamando al modal para el registro de anexos (se le enviará el id del contrato marco)
        return view('admin.contrato-marco.modals.create_anexos')->with([
            'id_contrato_marco' => $id,
            'anexos_disponibles' => $this->obtenerDocumentosDisponibles($this->hashDecode($id))
        ]);
    }

    public function fetch_anexoscm() {
        $acm = $this->hashEncode(AnexosContratoMarco::allAnexosCM(session()->get('contrato') != null ? $this->hashDecode(session()->get('contrato')) : 0));
        return Datatables::of($acm)->toJson();
    }

    public function manejoArchivos($archivo) { //Funcion que permite generar nuevo nombre y guardar archivos en storage
        $a_nombre_unico = time() . Str::random(15) . $archivo->getClientOriginalName(); //Asignando un nombre unico al archivo (con time) para que sea guardado
        Storage::disk('public')->put('anexos_contrato/' . $a_nombre_unico, File::get($archivo)); //Guardando en disco el archivo con el nuevo nombre asignado
        return $a_nombre_unico;
    }

    /**
     * Descarga archivo tomando en cuenta el id y el tipo de archivo (original o publico).
     *
     * @param  int  $id
     * @param  string  $tipo_archivo
     * @return \Illuminate\Http\Response
     */
    public function descargar_archivo($archivo) { //Funcion que permite buscar el archivo mendiante su id para su posterior visualización
        $file = Storage::disk('public')->get('anexos_contrato/'  . $archivo); //Instrucciones que permiten visualizar archivo
        return  Response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $archivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
        ]);
    }
}
