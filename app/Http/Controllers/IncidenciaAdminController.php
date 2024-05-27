<?php

namespace App\Http\Controllers;

use App\Models\ContratoMarcoUrg;
use App\Models\HabilitarProveedore;
use App\Models\Incidencia;
use App\Models\OrdenCompra;
use App\Models\OrdenCompraProveedor;
use App\Models\Proveedor;
use App\Models\ProveedorFichaProducto;
use App\Models\User;
use App\Traits\HashIdTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class IncidenciaAdminController extends Controller
{

    use HashIdTrait;

    public function index(){
        $contadoresUrg = Incidencia::adminUrgCount();
        $contadoresProveedor = Incidencia::adminProveedorCount();
        $contadoresAdmin = Incidencia::adminCount(auth()->user()->id);

        $origenUrg = Incidencia::origenUrg();
        $urgs = $this->hashEncode(incidencia::Urgs());
        $origenProveedor = Incidencia::origenProveedor();
        $proveedores = $this->hashEncode(Incidencia::proveedores());
        $adminUrgs = $this->hashEncode(Incidencia::adminUrg(auth()->user()->id));
        $adminProveedores = $this->hashEncode(Incidencia::adminProveedor(auth()->user()->id));
        $adminOrigen = Incidencia::adminOrigen(auth()->user()->id);
        
        return view('admin.incidencias.index')->with(['contadoresUrg' => $contadoresUrg[0], 'contadoresProveedor' => $contadoresProveedor[0], 'contadoresAdmin' => $contadoresAdmin[0], 'origenUrg' => $origenUrg, 'urgs' => $urgs, 'origenProveedor' => $origenProveedor, 'proveedores' => $proveedores, 'adminUrgs' => $adminUrgs, 'adminProveedores' => $adminProveedores, 'adminOrigen' => $adminOrigen]);
    }

    public function dataUrg(){
        $incidencia = $this->hashEncode(Incidencia::adminIncidenciaUrg());
        foreach($incidencia as $key => $value){
            $incidencia[$key]->tiempo_respuesta = null;
            if($value->fecha_respuesta != null){
                $diferencia = Carbon::parse($value->created_at)->diffInDays($value->fecha_respuesta, false);
                $incidencia[$key]->tiempo_respuesta = $diferencia; 
            }
            if($value->proveedor_id != null){
                $this->hashEncodeIdClave($incidencia,'proveedor_id','proveedor_id_e');
            }
        }

        return Datatables::of($incidencia)->toJson();
    }

    public function dataUrgFiltro($filtro){
        $filtro = explode('-',$filtro);

        switch ($filtro[0]) {
            case 'urg':
                if($filtro[1] == "todos"){
                    return $this->dataUrg();
                }
                $incidencia = Incidencia::adminIncidenciaFiltroUrg($this->hashDecode($filtro[1]));
                
                break;
            case 'urg_origen':
                if($filtro[1] == "todos"){
                    return $this->dataUrg();
                }
                $incidencia = Incidencia::adminIncidenciaFiltroUrgOrigen($filtro[1]);
                break;
            case 'urg_estatus':
                if($filtro[1] == "todos"){
                    return $this->dataUrg();
                }
                $incidencia = Incidencia::adminIncidenciaFiltroUrgEstatus($filtro[1]);
                break;
            case 'fecha':
                 $de = str_replace("_", "/", $filtro[1]);
                 $hasta = str_replace("_", "/", $filtro[2]);

                 $incidencia = Incidencia::adminIncidenciaFiltroUrgFecha($de,$hasta);
                break;
        }

        if($incidencia != '[]'){
            foreach($incidencia as $key => $value){
                $incidencia[$key]->tiempo_respuesta = null;
                if($value->fecha_respuesta != null){
                    $diferencia = Carbon::parse($value->created_at)->diffInDays($value->fecha_respuesta, false);
                    $incidencia[$key]->tiempo_respuesta = $diferencia; 
                }
                if($value->proveedor_id != null){
                    $this->hashEncodeIdClave($incidencia,'proveedor_id','proveedor_id_e');
                }
            }
        }

        return Datatables::of($incidencia)->toJson();
    }

    public function modalInfoProveedor($id){
        $proveedor = Proveedor::find($this->hashDecode($id));

        return view('admin.incidencias.modal.info_proveedor')->with(['proveedor' => $proveedor]);
    }

    public function modalRespuesta(){
        return view('admin.incidencias.modal.respuesta_modal');
    }

    public function combosRespuesta($escala){
        $combos = ['Leve' => ['Llamado de atención'], 'Moderada' => ['Suspensión de productos','Suspensión temporal del acceso al Sistema de Contrato Marco'], 'Grave' => ['Suspensión indefinida de acceso al Sistema de Contrato Marco', 'Eliminación de productos']];

        return $combos[$escala];
    }

    public function respuestaSave(Request $request){
        try {
            $incidencia = Incidencia::find($this->hashDecode($request->input('incidente')));
            $incidencia->fecha_respuesta = Carbon::createFromFormat('d/m/Y',$request->input('fecha_respuesta')); 
            $incidencia->escala = $request->input('escala');
            $incidencia->sancion = $request->input('sancion');
            $incidencia->respuesta = $request->input('respuesta');
            $incidencia->admin_atendio = auth()->user()->id;
            $incidencia->update();
            
            $response = ['success' => true, 'message' => 'Incidencia respondida correctamente.'];
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'No se pudo responder la incidencia.'];   
        }

        return $response;
    }

    public function dataProveedor(){
        $incidencia = $this->hashEncode(Incidencia::adminIncidenciaProveedor());
        foreach($incidencia as $key => $value){
            $incidencia[$key]->tiempo_respuesta = null;
            if($value->fecha_respuesta != null){
                $diferencia = Carbon::parse($value->created_at)->diffInDays($value->fecha_respuesta, false);
                $incidencia[$key]->tiempo_respuesta = $diferencia; 
            }
            if($value->proveedor_id != null){
                $this->hashEncodeIdClave($incidencia,'user_creo','user_creo');
            }
        }
        
        return Datatables::of($incidencia)->toJson();
    }

    public function dataProveedorFiltro($filtro){
        $filtro = explode('-',$filtro);
        switch ($filtro[0]) {
            case 'proveedor':
                if($filtro[1] == "todos"){
                    return $this->dataProveedor();
                }
                $incidencia = Incidencia::adminIncidenciaFiltroProveedor($this->hashDecode($filtro[1]));
                break;
            case 'proveedor_origen':
                if($filtro[1] == "todos"){
                    return $this->dataProveedor();
                }
                $incidencia = Incidencia::adminIncidenciaFiltroProveedorOrigen($filtro[1]);
                break;
            case 'proveedor_estatus':
                if($filtro[1] == "todos"){
                    return $this->dataProveedor();
                }
                $incidencia = Incidencia::adminIncidenciaFiltroProveedorEstatus($filtro[1]);
                break;
            case 'fecha':
                 $de = str_replace("_", "/", $filtro[1]);
                 $hasta = str_replace("_", "/", $filtro[2]);

                 $incidencia = Incidencia::adminIncidenciaFiltroProveedorFecha($de,$hasta);
                break;
        }
        if($incidencia != '[]'){
            foreach($incidencia as $key => $value){
                $incidencia[$key]->tiempo_respuesta = null;
                if($value->fecha_respuesta != null){
                    $diferencia = Carbon::parse($value->created_at)->diffInDays($value->fecha_respuesta, false);
                    $incidencia[$key]->tiempo_respuesta = $diferencia; 
                }
                if($value->proveedor_id != null){
                    $this->hashEncodeIdClave($incidencia,'user_creo','user_creo');
                }
            }
        }
        
        return Datatables::of($incidencia)->toJson();
    }

    public function modalInfoUrg($id){
        $user = User::find($this->hashDecode($id));

        return view('admin.incidencias.modal.info_user')->with(['user' => $user]);
    }

    public function dataAdmin(){
        $incidencia = $this->hashEncode(Incidencia::adminIncidencia(auth()->user()->id));
        
        return Datatables::of($incidencia)->toJson();
    }

    public function dataAdminFiltro($filtro){
         $filtro = explode('-',$filtro);
         switch ($filtro[0]) {
            case 'admin_urg':
                if($filtro[1] == "todos"){
                    return $this->dataAdmin();
                }
                $incidencia = Incidencia::adminIncidenciaFiltroUrgs(auth()->user()->id,$this->hashDecode($filtro[1]));
                break;
            case 'admin_proveedor':
                if($filtro[1] == "todos"){
                    return $this->dataAdmin();
                }
                $incidencia = Incidencia::adminIncidenciaFiltroProveedores(auth()->user()->id,$this->hashDecode($filtro[1]));
                break;
            case 'admin_origen':
                if($filtro[1] == "todos"){
                    return $this->dataAdmin();
                }
                $incidencia = Incidencia::adminIncidenciaFiltroOrigen(auth()->user()->id,$filtro[1]);
                break;
            case 'admin_escala':
                if($filtro[1] == "todos"){
                    return $this->dataAdmin();
                }
                $incidencia = Incidencia::adminIncidenciaFiltroEscala(auth()->user()->id,$filtro[1]);
                break;
            case 'fecha':
                $de = str_replace("_", "/", $filtro[1]);
                $hasta = str_replace("_", "/", $filtro[2]);

                $incidencia = Incidencia::adminIncidenciaFiltroFecha(auth()->user()->id,$de,$hasta);
                break;
         }
         return Datatables::of($incidencia)->toJson();
    }

    public function modalAdminIncidencia(){
        return view('admin.incidencias.modal.abrir_incidencia_modal');
    }

    public function combosUsuarios($usuario){
        if($usuario == 1){
            $usuarios = $this->hashEncodeIdClave(User::nombre(), 'id', 'user_id');
        }
        if($usuario == 2)
        {
            $usuarios = $this->hashEncodeIdClave(Proveedor::razon(),'id','user_id');
        }
        $origen = [1 => ['cm' => 'Contrato Marco', 'oc' => 'Orden de Compra', 'g' => 'General'], 2 => ['cm' => 'Contrato Marco', 'oc' => 'Orden de Compra', 'fp' => 'Ficha producto', 'g' => 'General']];
        
        return ['usuarios' => $usuarios, 'origen' => $origen[$usuario]];
    }

    public function combosIdOrigen($userId, $origen, $tipoUser){

        switch ($origen) {
            case 'cm':
                if($tipoUser == 1){
                    $urg = User::select('urg_id')->where('id',$this->hashDecode($userId))->get();
                    $origenId = ContratoMarcoUrg::comboOrigenCmUrg($urg[0]->urg_id);
                }else{
                    $origenId = HabilitarProveedore::comboOrigenCmPro($this->hashDecode($userId));
                }
                break;
            case 'oc':
                if($tipoUser == 1){
                    $urg = User::select('urg_id')->where('id',$this->hashDecode($userId))->get();
                    $origenId = OrdenCompra::comboOrigenOcUrg($urg[0]->urg_id);
                }else{
                    $origenId = OrdenCompraProveedor::comboOrigenOcPro($this->hashDecode($userId));
                }
                break;
            case 'g':
                $origenId = [0 => ['origen' => 'General']];
                break;
            case 'fp':
               $origenId = ProveedorFichaProducto::productoId($this->hashDecode($userId));
                break;
        }
        return $origenId;
    }

    public function comboSancion($escala){
        switch ($escala) {
            case 'Leve':
                $sancion = [1 => 'Llamado de atención'];
                break;
            case 'Moderada':
                $sancion = [2 => 'Suspensión de productos', 3 => 'Suspensión temporal del acceso al Sistema de Contrato Marco.'];
                break;
            case 'Grave':
                $sancion =  [4 => 'Suspensión indefinida de acceso al Sistema de Contrato Marco.', 5 => 'Eliminación de productos'];
                break;
            
        }

        return $sancion;
    }

    public function comboMotivo($sancion,$tipoUser){
        switch ($sancion) {
            case 1:
                $motivo = [1 => ['Retraso en ingreso de información.', 'Retraso en carga de documentación.', 'Falta de respuesta a requerimientos de información expresos.', 'Cancelación de O.C. por errores cometidos durante la compra por más de 3 veces en un mismo año fiscal.', 'Estados de Contrato pedido desactualizados.', 'Estados de Contrato tipo desactualizados.', 'Retraso de más de 2 días en la evaluación del proveedor.', 'Incumplimientos eventuales en las obligaciones señaladas en los Lineamientos Administrativos.', 'Incumplimientos eventuales en las obligaciones señaladas en los Términos generales.', 'Datos de contacto desactualizados (Acceso único).'], 2 => ['Retraso en ingreso de información requerida.', 'Retraso en carga de documentos.', 'Falta de respuesta a requerimientos de información expresos.', 'Incumplimientos eventuales en las obligaciones señaladas en los Lineamientos Administrativos.', 'Incumplimientos eventuales en las obligaciones señaladas en los Términos generales.', 'Incumplimientos en cambios solicitados.', 'Ficha técnica incompleta.', 'Estados de Contrato pedido desactualizados.', 'Estados de Contrato tipo desactualizados.', 'Retraso en entrega del pedido.', 'Errores recurrentes en factura timbrada.', 'Error en monto facturado.', 'Datos de contacto desactualizados (Matriz de escalamiento).', 'Cancelación de OC cuando la justificación no se encuentre en los motivos permitidos los cuales se establecen en los lineamientos.', 'Modificación del precio de los productos, antes del término de la vigencia establecida.']];
                break;
            case 2:
                $motivo = [1 => ['NO APLICA'], 2 => ['Retraso en la actualización de precio en la ficha del producto', 'Evidencia de que un producto no se ajusta a la oferta presentada.', 'No actualización en el stock de los productos.', 'Incumplimientos eventuales en las obligaciones señaladas en el Contrato pedido.', 'Incumplimientos eventuales en las obligaciones señaladas en el Contrato tipo.', 'Entrega de productos incorrectos por más de 3 veces en diferentes contratos en un mismo año fiscal.', 'Solicitar más de 5 veces prórrogas en diferentes contratos en un mismo año fiscal.', 'Incurrir 3 veces en un mismo año fiscal en inconformidades de los productos al estándar de productos.']] ;
                break;
            case 3:
                $motivo = [1 => ['Retraso de más de 30 días en el pago, en más de 3 contratos diferentes dentro de un mismo año fiscal.', 'Incurrir 3 veces en un mismo año fiscal en causales leves.', 'Retraso en firma de Contrato Pedido/Contrato Tipo, más de 3 ocasiones en un mismo año fiscal.', 'Incurrir en las causales de terminación de Acuerdo de Servicios señaladas en el marco normativo.', 'Retraso de validación técnica.', 'Reprogramar entrega por falta de coordinación al el almacén.', 'Incumplimientos eventuales en las obligaciones señaladas en el Contrato pedido.', 'Incumplimientos eventuales en las obligaciones señaladas en el Contrato tipo.'], 2 => ['Incurrir en las causales de terminación de Acuerdo de Servicios señaladas en el marco normativo.', 'Retraso en más de 3 ocasiones en contratos diferentes  en la firma de Contrato Pedido/Contrato Tipo en un mismo año fiscal.', 'Incurrir 3 veces en un mismo año fiscal en causales leves.']];
                break;
            case 4:
                $motivo = [1 => ['Entregar información/documentación errónea en cualquier apartado de la plataforma Contrato Marco.', 'No contar con la suficiencia presupuestaria.', 'Cancelación de OC ya que se adjudicó a un proveedor.', 'Incurrir más de 3 veces en causales moderadas en un mismo año fiscal.', 'Deuda con el proveedor.'], 2 => ['Entregar información/documentación falsa.', 'Incurrir 3 veces en causales moderadas en un mismo año fiscal.', 'Entregar mercancía incompleta 3 veces en diferentes contratos durante el mismo año fiscal.', 'Rechazar OC una vez declarado ganador.']];
                break;
            case 5:
                $motivo = [1 => ['No aplica'], 2 => ['El producto no se ajusta a la oferta presentada (Calidad en relación a ficha técnica - estándares de producto).', 'Más de 3 veces incidencias referentes al stock del producto.']];
                break;
            
        }

        return $motivo[$tipoUser];
    }

    public function saveIncidencia(Request $request){
        try {
            $ultimoId = Incidencia::ultimo();
            $ultimo = 1;
            if(isset($ultimoId[0]->id)){
                $ultimo = $ultimoId[0]->id + 1;
            }
            $incidencia = new Incidencia();
            $incidencia->id_incidencia = auth()->user()->rfc.date('dmY').substr($request->input('escala'),0,1).$ultimo;
            $incidencia->motivo = $request->input('motivo');
            $incidencia->descripcion = $request->input('descripcion');
            $incidencia->etapa = $request->input('origen');
            $incidencia->etapa_id = $request->input('id_origen');
            $incidencia->reporta = 1;
            $incidencia->escala = $request->input('escala');
            $incidencia->sancion = $request->input('sancion');
            $incidencia->user_creo = auth()->user()->id;
            if($request->input('usuario') == 1){
                $user = User::select('urg_id')->where('id',$this->hashDecode($request->input('nombre')))->get();
                $incidencia->user_id = $this->hashDecode($request->input('nombre'));
                $incidencia->urg_id = $user[0]->urg_id;
            }
            if($request->input('usuario') == 2){
                $incidencia->proveedor_id = $this->hashDecode($request->input('nombre'));
            }
            $incidencia->save();
           
            $response = ['success' => true, 'message' => 'Incidencia registrada correctamente.'];
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'La incidencia no se pudo crear.'.$e];
        }

        return $response;
    }

}