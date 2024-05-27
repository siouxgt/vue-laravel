<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Date;
use App\Models\ContratoMarco;
use App\Models\Submenu;
use App\Models\Urg;
use App\Models\User;
use App\Models\ValidacionesTecnicas;
use App\Traits\ContratoTrait;
use App\Traits\HashIdTrait;
use App\Traits\SessionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContratoMarcoController extends Controller {
    use HashIdTrait, SessionTrait, ContratoTrait;

    public function index() {
        $this->eliminarSession(['contrato', 'nombreCm']);

        $vigentes = $this->hashEncode(ContratoMarco::vigentes());
        $porLiberar = $this->hashEncode(ContratoMarco::porLiberar());
        $porVencer = $this->hashEncode(ContratoMarco::porVencer());
        $vencidos = $this->hashEncode(ContratoMarco::vencidos());

        return view('admin.contrato-marco.index')->with(['vigentes' => $vigentes, 'porLiberar' => $porLiberar, 'porVencer' => $porVencer, 'vencidos' => $vencidos]);
    }

    public function create() {
        $this->eliminarSession(['contrato', 'nombreCm']);
        return view('admin.contrato-marco.create')->with([
            'ultimo_id' => $this->siguienteId(),
            'fecha_actual' => Carbon::now()->format('d/m/Y'),
            'fecha_inicio' => Carbon::now()->format('Y-m-d'),
            'fecha_fin' => Carbon::now()->addYears(5)->format('Y-m-d'),
            'entidad_adm' => $this->hashEncode(Urg::where('estatus', 'true')->get()),
        ]);
    }

    public function store(Request $request) {
        $fechaInicio = Carbon::now()->format('Y-m-d');
        $fechaFin = Carbon::now()->addYears(5)->format('Y-m-d');
        $validator = Validator::make(
            $request->all(),
            [
                'nombre_cm' => 'required|max:100',
                'numero_cm' => 'required|max:150',
                'f_inicio' => "required|date_format:Y-m-d|in:$fechaInicio",
                'f_fin' => "required|date_format:Y-m-d|in:$fechaFin",
                'objetivo' => 'required',
                'entidad_administradora' => 'required',
                'capitulo'    => 'required|array',
                'partida'    => 'required|array',
                'validaciones_seleccionadas' => Rule::requiredIf($request->input('val_tec') == 'on' ? true : false), //Es un select
                'sector' => 'required',
                'responsable_sel' => 'required',
            ],
            [
                'nombre_cm.required' => 'Declare el nombre del contrato marco por favor.',
                'numero_cm.required' => 'Es necesario el número de contrato marco.',
                'f_inicio.required' => 'Declare la fecha de inicio del contrato por favor.',
                'f_fin.required' => 'Declare la fecha de fin del contrato por favor.',
                'objetivo.required' => 'Declare los objetivos del contrato marco.',
                'entidad_administradora.required' => 'Es necesario que seleccione la entidad administradora.',
                'capitulo.required' => 'Es necesario que seleccione el capítulo.',
                'partida.required' => 'Es necesario que seleccione la partida.',
                'sector.required' => 'Es necesario que seleccione el sector.',
                'responsable_sel.required' => 'Seleccione al responsable del contrato marco por favor.',
            ],

        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $cm = new ContratoMarco();
            $cm->numero_cm = $request->input('numero_cm');
            $cm->nombre_cm = $request->input('nombre_cm');
            $cm->objetivo = $request->input('objetivo');
            $cm->f_inicio = $request->input('f_inicio');
            $cm->f_fin = $request->input('f_fin');
            $cm->urg_id = $this->hashDecode($request->input('entidad_administradora'));
            $cm->user_id_responsable = $this->hashDecode($request->input('responsable_sel')); //Enviando el ID del URG responsable (Se le ha restado una unidad)
            $cm->user_id_creo = auth()->user()->id;
            //------------------------------------------------------------------------------------
            //Capturando capitulos y partidas de los select
            //------------------------------------------------------------------------------------
            foreach ($request->input('capitulo') as $key => $cap) {
                $capa[$key]['capitulo'] = $cap;

                $cadena_de_texto = $request->input('partida')[$key];
                $lapartida = substr($cadena_de_texto, 0, 4);
                $ladescripcion = substr($cadena_de_texto, 5);
                $capa[$key]['partida'] = $lapartida;
                $capa[$key]['descripcion'] = $ladescripcion;
            }
            $cm->capitulo_partida = json_encode($capa);
            //------------------------------------------------------------------------------------
            $cm->compras_verdes = $request->input('compras_verdes') == 'on' ? true : false;
            $cm->validacion_tecnica = $request->input('val_tec') == 'on' ? true : false;
            if ($cm->validacion_tecnica) {
                //------------------------------------------------------------------------------------
                //Capturando las validaciones tecnicas elegidas del select
                //------------------------------------------------------------------------------------             
                foreach ($request->input('validaciones_seleccionadas') as $key => $vs) {
                    $vtecs[$key]['id_val_sel'] = $vs;
                }
                $cm->validaciones_seleccionadas = json_encode($vtecs);
            } else {
                $vtec[0]['id_val_sel'] = "No hay validaciones";
                $cm->validaciones_seleccionadas = json_encode($vtec);
            }
            //------------------------------------------------------------------------------------
            //Capturando los sectores especificos que han seleccionados
            foreach ($request->input('sector') as $key => $sector) {
                $sectores[$key]['sector'] = $sector;
            }
            $cm->sector = json_encode($sectores);

            if ($request->file('imagen')) {
                $nombre = time() . $request->file('imagen')->getClientOriginalName();
                Storage::disk('img_contrato')->put($nombre, File::get($request->file('imagen')));
                $cm->imagen = $nombre;
            }
            $cm->porcentaje = 10;
            $cm->save();

            $submenu = new Submenu();
            $submenu->contrato_id = $cm->id;
            $submenu->save();

            $cm = $this->hashEncode($cm);

            $this->crearSession(['contrato' => $cm->id_e, 'nombreCm' => $cm->nombre_cm]);
            return response()->json(['status' => 200, 'message' => 'Contrato marco dado de alta correctamente.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $cm = $this->hashEncode(ContratoMarco::find($this->hashDecode($id)));
        $cm->capitulo_partida = json_decode($cm->capitulo_partida);
        $cm->validaciones_seleccionadas = json_decode($cm->validaciones_seleccionadas);
        $cm->sector = json_decode($cm->sector);
        $fechas = $this->fechasContrato($this->hashDecode($id));
        $this->crearSession(['contrato' => $cm->id_e, 'nombreCm' => $cm->nombre_cm]);

        return view('admin.contrato-marco.edit')->with([
            'cm' => $cm,
            'entidad_adm' => $this->hashEncode(Urg::where('estatus', 'true')->get()),
            'responsables_vt' => $this->responsablesvt(),
            'fechas' => $fechas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $reglaFechaInicio = "";
        $validator = Validator::make(
            $request->all(),
            [
                'nombre_cm' => 'required|max:100',
                'numero_cm' => 'required|max:150',
                'f_inicio' => '',
                'f_fin' => '',
                'objetivo' => 'required',
                'entidad_administradora' => 'required',
                'capitulo'    => 'required|array',
                'partida'    => 'required|array',
                'validaciones_seleccionadas' => Rule::requiredIf($request->input('val_tec') == 'on' ? true : false), //Es un select
                'sector' => 'required',
                'responsable_sel' => 'required',
            ],
            [
                'nombre_cm.required' => 'Declare el nombre del contrato marco por favor.',
                'numero_cm.required' => 'Es necesario el número de contrato marco.',
                // 'f_inicio.required' => 'Declare la fecha de inicio del contrato por favor.',
                // 'f_fin.required' => 'Declare la fecha de fin del contrato por favor.',
                'objetivo.required' => 'Declare los objetivos del contrato marco.',
                'entidad_administradora.required' => 'Es necesario que seleccione la entidad administradora.',
                'capitulo.required' => 'Es necesario que seleccione el capítulo.',
                'partida.required' => 'Es necesario que seleccione la partida.',
                'sector.required' => 'Es necesario que seleccione el sector.',
                'responsable_sel.required' => 'Seleccione al responsable del contrato marco por favor.',
            ],

        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $cm = ContratoMarco::find($this->hashDecode(session()->get('contrato')));
            $cm->numero_cm = $request->input('numero_cm');
            $cm->nombre_cm = $request->input('nombre_cm');
            $cm->objetivo = $request->input('objetivo');
            // $cm->f_inicio = Carbon::createFromFormat('d/m/Y', $request->input('f_inicio'));
            // $cm->f_fin = Carbon::createFromFormat('d/m/Y', $request->input('f_fin'));
            $cm->urg_id = $this->hashDecode($request->input('entidad_administradora'));
            $cm->user_id_responsable =  strlen($request->input('responsable_sel')) == 8 ? $this->hashDecode($request->input('responsable_sel')) : $request->input('responsable_sel'); //Enviando el ID del URG responsable (Se le ha restado una unidad)
            //------------------------------------------------------------------------------------
            //Capturando capitulos y partidas de los select
            //------------------------------------------------------------------------------------
            $contador = 0;
            foreach ($request->input('capitulo') as $key => $cap) {
                $capa[$contador]['capitulo'] = $cap;

                $cadena_de_texto = $request->input('partida')[$key];
                $lapartida = substr($cadena_de_texto, 0, 4);
                $ladescripcion = substr($cadena_de_texto, 5);
                $capa[$contador]['partida'] = $lapartida;
                $capa[$contador]['descripcion'] = $ladescripcion;
                $contador++;
            }
            $cm->capitulo_partida = json_encode($capa);

            //------------------------------------------------------------------------------------
            $cm->compras_verdes = $request->input('compras_verdes') == 'on' ? true : false;
            $cm->validacion_tecnica = $request->input('val_tec') == 'on' ? true : false;
            if ($cm->validacion_tecnica) {
                //------------------------------------------------------------------------------------
                //Capturando las validaciones tecnicas elegidas del select
                //------------------------------------------------------------------------------------             
                foreach ($request->input('validaciones_seleccionadas') as $key => $vs) {
                    $vtecs[$key]['id_val_sel'] = $vs;
                }
                $cm->validaciones_seleccionadas = json_encode($vtecs);
            } else {
                $vtec[0]['id_val_sel'] = "No hay validaciones";
                $cm->validaciones_seleccionadas = json_encode($vtec);
            }
            //------------------------------------------------------------------------------------
            //Capturando los sectores especificos que han seleccionados
            foreach ($request->input('sector') as $key => $sector) {
                $sectores[$key]['sector'] = $sector;
            }
            $cm->sector = json_encode($sectores);
            if ($request->file('imagen')) {
                if (Storage::disk('img_contrato')->exists($cm->imagen)) {
                    Storage::disk('img_contrato')->delete($cm->imagen);
                }
                $nombre = time() . $request->file('imagen')->getClientOriginalName();
                Storage::disk('img_contrato')->put($nombre, File::get($request->file('imagen')));
                $cm->imagen = $nombre;
            }
            $cm->update();
            $cm = $this->hashEncode($cm);
            $idRecienGuardado = $cm->id_e; //Obteniendo el id que se acaba de registrar          
            return response()->json([
                'status' => 200, 'message' => 'Contrato marco dado de alta correctamente.', 'id_rg' => $idRecienGuardado
            ]);
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

    public function siguienteId() {
        return (DB::select("SELECT max(id) as maximo FROM contratos_marcos")[0]->maximo) + 1;
    }

    public function responsables($urg_id) //Funcion que obtiene los responsables de las URG
    {
        $urg_id = $this->hashDecode($urg_id);
        if ($urg_id != 0) { //Comprobar si en verdad se ha seleccionado URG valida
            $responsables = $this->hashEncode(User::UserResponsables($urg_id));
        }

        return ["responsables" => $responsables];
    }

    public function responsablesvt() { //Funcion que permite cargar los responsables de las validaciones tecnicas (Solo serán cargados los que estan activos)
        $valTec = $this->hashEncode(ValidacionesTecnicas::allValidaciones("true"));

        if (count($valTec) != 0) {
            return $valTec;
        } else {
            return [];
        }
    }

    // public function buscarContratosM() { //Funcion que permite obtener el nombre de todos los contratos marco registrados
    //     return DB::select("SELECT id, nombre_cm FROM contratos_marcos");
    // }

    public function serviceCapitulosP($capitulo) {
        $partidas = Http::get("https://aplicaciones.finanzas.cdmx.gob.mx/almaceneseinventarioscdmx/public/api/par_pre/" . $capitulo . "/1");

        if ($partidas->status() == 200) {
            $response = array('success' => true, 'data' => $partidas->json());
        } else {
            $response = ['success' => false, 'message' => 'Error capitulos no disponibles.'];
        }
        return $response;
    }

    public function liberar() {
        $id = $this->hashDecode(session('contrato'));
        $contrato = ContratoMarco::find($id);
        if ($contrato->porcentaje == 100) {
            $contrato->liberado = true;
            $contrato->update();

            $response = array('success' => true, 'message' => 'Contrato Marco liberado correctamente.');
        } else {
            $response = ['success' => false, 'message' => 'Contrato Marco incompleto ' . $contrato->porcentaje . '%/100%.'];
        }

        return $response;
    }

    public function filtros($tipo) {

        switch ($tipo) {
            case 'vigentes':
                $contratos = $this->hashEncode(ContratoMarco::vigentes());
                $contratos = $this->fechasDiff($contratos);
                break;
            case 'xliberar':
                $contratos = $this->hashEncode(ContratoMarco::porLiberar());
                $contratos = $this->fechasDiff($contratos);
                break;
            case 'xvencer':
                $contratos = $this->hashEncode(ContratoMarco::porVencer());
                $contratos = $this->fechasDiff($contratos);
                break;
            case 'vencido':
                $contratos = $this->hashEncode(ContratoMarco::vencidos());
                $contratos = $this->fechasDiff($contratos);
                break;
        }

        return  ['success' => true, 'data' => $contratos];
    }
}
