<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReporteUrg extends Model
{
    use HasFactory;

     protected $casts = [
        'created_at' => 'date:d/m/Y',
    ];

    public function urg(){
        return $this->belongsTo(Urg::class);
    }

    public static function reportesAll(){
        return DB::select("SELECT r.id, r.nombre_reporte, to_char(r.created_at,'DD/MM/YYYY') AS fecha FROM reporte_urgs AS r");
    }

     public static function analiticoCM($parametros){
        $sql = "SELECT cm.numero_cm, cm.objetivo, 'ADQUISICIÓN DE BIENES' AS tipo_contratacion, TO_CHAR(cm.created_at,'DD/MM/YYYY') AS fecha_creacion, TO_CHAR(cm.f_fin,'DD/MM/YYYY') AS fecha_fin, TO_CHAR(cm.updated_at,'DD/MM/YYYY') AS fecha_modificacion, (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = cm.user_id_responsable) AS responsable, (SELECT TO_CHAR(MIN(cmu.created_at),'DD/MM/YYYY') FROM contratos_marcos_urgs AS cmu WHERE cmu.contrato_marco_id = cm.id) AS fecha_urg, (SELECT TO_CHAR(MIN(hp.created_at),'DD/MM/YYYY') FROM habilitar_proveedores AS hp WHERE hp.contrato_id = cm.id) AS fecha_proveedor, cm.capitulo_partida, (SELECT COUNT(cmu.id) FROM contratos_marcos_urgs AS cmu WHERE cmu.contrato_marco_id = cm.id) AS total_urg, (SELECT COUNT(DISTINCT hp.proveedor_id) FROM habilitar_proveedores AS hp WHERE hp.contrato_id = cm.id) AS total_proveedor, CASE WHEN cm.liberado = true THEN 'ACTIVO' ELSE 'INACTIVO' END estatus, (SELECT COUNT(c.id) FROM contratos AS c WHERE c.contrato_marco_id = cm.id) AS orden_compra
            FROM contratos_marcos AS cm";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 0;
        
        if($parametros->contrato != ""){
            $sql .= " ".$condicion[$contador]." cm.id = ".$parametros->contrato;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from cm.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio ){
                $sql .= " ".$condicion[$contador]. " cm.created_at <= '".$parametros->fecha_reporte."'";    
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." cm.created_at BETWEEN '".$parametros->de."' AND '".$parametros->hasta."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]. " cm.created_at <= '".$parametros->fecha_reporte."'";
        }
        
        return DB::select($sql);
   }

   public static function reporteAdProveedor($parametros){
        $sql = "SELECT cm.numero_cm, cm.nombre_cm, cm.objetivo, p.nombre AS proveedor, p.rfc, TO_CHAR(hp.fecha_adhesion,'DD/MM/YYYY') AS fecha_adhesion, TO_CHAR(cm.f_fin,'DD/MM/YYYY') AS fecha_fin, CASE WHEN hp.habilitado = true THEN 'ACTIVO' ELSE 'INACTIVO' END AS estatus
            FROM habilitar_proveedores AS hp 
            JOIN proveedores AS p ON hp.proveedor_id = p.id
            JOIN contratos_marcos AS cm ON hp.contrato_id = cm.id";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 0;

        if($parametros->contrato != ""){
            $sql .= " ".$condicion[$contador]." cm.id = ".$parametros->contrato;
            $contador = 1;
        }
        if($parametros->proveedor != ""){
            $sql .= " ".$condicion[$contador]." p.id = ".$parametros->proveedor;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from hp.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio){
                $sql .= " ".$condicion[$contador]." hp.created_at <= '".$parametros->fecha_reporte."'";    
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." hp.created_at BETWEEN '".$parametros->de."' AND '".$parametros->hasta."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]." hp.created_at <= '".$parametros->fecha_reporte."'";
        }

        return DB::select($sql);
   }

   public static function reporteAdUrg($parametros){
        $sql ="SELECT cm.numero_cm, cm.nombre_cm, cm.objetivo, u.nombre, u.ccg, TO_CHAR(cmu.created_at,'DD/MM/YYYY') AS fecha_adhesion, TO_CHAR(cm.f_fin,'DD/MM/YYYY') AS fecha_fin, CASE WHEN cmu.estatus = true THEN 'ACTIVO' ELSE 'INACTIVO' END AS estatus
            FROM contratos_marcos_urgs AS cmu
            JOIN contratos_marcos AS cm ON cmu.contrato_marco_id = cm.id
            JOIN urgs AS u ON cmu.urg_id = u.id";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 0;

        if($parametros->contrato != ""){
            $sql .= " ".$condicion[$contador]." cm.id = ".$parametros->contrato;
            $contador = 1;
        }
        if($parametros->urg != ""){
            $sql .= " ".$condicion[$contador]." u.id = ".$parametros->urg;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from cmu.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio){
                $sql .= " ".$condicion[$contador]." cmu.created_at <= '".$parametros->fecha_reporte."'";
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." cmu.created_at BETWEEN '".$parametros->de."' AND '".$parametros->hasta."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]." cmu.created_at <= '".$parametros->fecha_reporte."'";
        }

        return DB::select($sql);
   }

   public static function reporteCp($parametros){
        $sql = "SELECT substring(cp.partida,1,4) AS partida, cp.cabms, substring(cp.capitulo,1,4) AS capitulo, TO_CHAR(cp.created_at,'DD/MM/YYYY') AS fecha_publicacion, 'SI' AS validacion_economica, CASE WHEN cp.validacion_tecnica = true THEN 'SI' ELSE 'NO' END AS validacion_tecnica, 'SI' AS validacion_administrativa, cm.nombre_cm, cm.numero_cm, cp.numero_ficha, (SELECT COUNT(pfp.id) FROM proveedores_fichas_productos AS pfp WHERE pfp.producto_id = cp.id) AS productos, cp.version
            FROM cat_productos AS cp 
            JOIN contratos_marcos AS cm ON cp.contrato_marco_id = cm.id";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 0;

        if($parametros->contrato != ""){
            $sql .= " ".$condicion[$contador]." cm.id = ".$parametros->contrato;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from cp.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio){
                $sql .= " ".$condicion[$contador]." cp.created_at <= '".$parametros->fecha_reporte."'";    
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." cp.created_at BETWEEN '".$parametros->de."' AND '".$parametros->hasta."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]." cp.created_at <= '".$parametros->fecha_reporte."'";
        }

        return DB::select($sql);
   }

   public static function reporteInPro($parametros){
        $sql = "SELECT i.id_incidencia, p.nombre, p.rfc, i.etapa, i.etapa_id, i.motivo, i.descripcion, TO_CHAR(i.created_at,'DD/MM/YYYY') AS fecha_creacion, i.sancion, (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = i.user_creo) AS usuario
            FROM incidencias AS i
            JOIN proveedores AS p ON i.proveedor_id = p.id
            WHERE i.reporta = 1 OR i.reporta = 2";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 1;

        if($parametros->urg != ""){
            $sql .= " ".$condicion[$contador]." i.urg_id = ".$parametros->urg;
            $contador = 1;
        }
        if($parametros->proveedor != ""){
            $sql .= " ".$condicion[$contador]." p.id = ".$parametros->proveedor;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from i.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio){
                $sql .= " ".$condicion[$contador]." i.created_at <= '".$parametros->fecha_reporte."'";    
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." i.created_at BETWEEN '".$parametros->de."' AND '".$parametros->hasta."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]." i.created_at <= '".$parametros->fecha_reporte."'";    
        }

        return DB::select($sql);
   }

   public static function reporteOCCompleto($parametros){
        $sql = "SELECT oc.orden_compra, r.requisicion, u.ccg, u.nombre, ocb.cabms, pfp.descripcion_producto, ocb.tamanio, ocb.precio, ocb.cantidad, (((ocb.cantidad * ocb.precio) * .16) + (ocb.cantidad * ocb.precio)) AS total_iva, (ocb.cantidad * ocb.precio) AS total, CASE WHEN substring(ocb.cabms, 1, 1) = '1' THEN '1000' WHEN substring(ocb.cabms, 1, 1) = '2' THEN '2000' WHEN substring(ocb.cabms, 1, 1) = '3' THEN '3000' WHEN substring(ocb.cabms, 1, 1) = '4' THEN '4000' WHEN substring(ocb.cabms, 1, 1) = '5' THEN '5000' END AS capitulo, CASE WHEN (SELECT COUNT(cc.id) FROM cancelar_compras AS cc WHERE cc.orden_compra_id = oc.id AND cc.proveedor_id = p.id) != 0 THEN 'CANCELADA' WHEN (SELECT COUNT(rc.id) FROM rechazar_compras AS rc WHERE rc.orden_compra_id = oc.id AND rc.proveedor_id = p.id) != 0 THEN 'RECHAZADA' WHEN (SELECT oce.finalizada FROM orden_compra_estatuses AS oce WHERE oce.orden_compra_id = oc.id AND oce.proveedor_id = p.id) = 2 THEN 'FINALIZADA' ELSE 'EN PROCESO' END AS estatus, p.nombre AS proveedor, p.rfc, 'PEDIDO' AS tipo_contrato, cm.numero_cm, cm.nombre_cm, TO_CHAR(oc.created_at,'DD/MM/YYYY') AS fecha_creacion
            FROM orden_compra_biens AS ocb
            JOIN proveedores_fichas_productos AS pfp ON ocb.proveedor_ficha_producto_id = pfp.id
            JOIN proveedores AS p ON ocb.proveedor_id = p.id
            JOIN orden_compras AS oc ON ocb.orden_compra_id = oc.id 
            JOIN contratos AS c ON c.orden_compra_id =  oc.id
            JOIN urgs AS u ON ocb.urg_id = u.id
            JOIN requisiciones AS r ON ocb.requisicion_id = r.id
            JOIN contratos_marcos AS cm ON c.contrato_marco_id = cm.id";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 0;

        if($parametros->contrato != ""){
            $sql .= " ".$condicion[$contador]." cm.id = ".$parametros->contrato;
            $contador = 1;
        }
        if($parametros->urg != ""){
            $sql .= " ".$condicion[$contador]." u.id = ".$parametros->urg;
            $contador = 1;
        }
        if($parametros->proveedor != ""){
            $sql .= " ".$condicion[$contador]." p.id = ".$parametros->proveedor;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from oc.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio){
                $sql .= " ".$condicion[$contador]." ocb.created_at <= '".$parametros->fecha_reporte."'";    
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." oc.created_at BETWEEN '".$parametros->de."' AND '".$parametros->hasta."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]." ocb.created_at <= '".$parametros->fecha_reporte."'";
        }
        

        return DB::select($sql);
   }

   public static function reporteOCCProveedor($parametros){
        $sql = "SELECT oc.orden_compra, r.requisicion, u.ccg, u.nombre, ocb.cabms, pfp.descripcion_producto, ocb.tamanio, ocb.precio, ocb.cantidad, (((ocb.cantidad * ocb.precio) * .16) + (ocb.cantidad * ocb.precio)) AS total_iva, (ocb.cantidad * ocb.precio) AS total, CASE WHEN substring(ocb.cabms, 1, 1) = '1' THEN '1000' WHEN substring(ocb.cabms, 1, 1) = '2' THEN '2000' WHEN substring(ocb.cabms, 1, 1) = '3' THEN '3000' WHEN substring(ocb.cabms, 1, 1) = '4' THEN '4000' WHEN substring(ocb.cabms, 1, 1) = '5' THEN '5000' END AS capitulo, CASE WHEN (SELECT COUNT(cc.id) FROM cancelar_compras AS cc WHERE cc.orden_compra_id = oc.id AND cc.proveedor_id = p.id) != 0 THEN 'CANCELADA' WHEN (SELECT COUNT(rc.id) FROM rechazar_compras AS rc WHERE rc.orden_compra_id = oc.id AND rc.proveedor_id = p.id) != 0 THEN 'RECHAZADA' WHEN (SELECT oce.finalizada FROM orden_compra_estatuses AS oce WHERE oce.orden_compra_id = oc.id AND oce.proveedor_id = p.id) = 2 THEN 'FINALIZADA' ELSE 'EN PROCESO' END AS estatus, p.nombre AS proveedor, p.rfc, 'PEDIDO' AS tipo_contrato, cm.numero_cm, cm.nombre_cm, to_char(oc.created_at,'DD/MM/YYYY') AS fecha_creacion, p.nombre_legal, p.primer_apellido_legal, p.segundo_apellido_legal
            FROM orden_compra_biens AS ocb
            JOIN proveedores_fichas_productos AS pfp ON ocb.proveedor_ficha_producto_id = pfp.id
            JOIN proveedores AS p ON ocb.proveedor_id = p.id
            JOIN orden_compras AS oc ON ocb.orden_compra_id = oc.id 
            JOIN contratos AS c ON c.orden_compra_id =  oc.id
            JOIN urgs AS u ON ocb.urg_id = u.id
            JOIN requisiciones AS r ON ocb.requisicion_id = r.id
            JOIN contratos_marcos AS cm ON c.contrato_marco_id = cm.id";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 0;

        if($parametros->proveedor != ""){
            $sql .= " ".$condicion[$contador]." p.id = ".$parametros->proveedor;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from oc.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio){
                $sql .= " ".$condicion[$contador]." ocb.created_at <= '".$parametros->fecha_reporte."'";    
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." oc.created_at BETWEEN '".$parametros->de."' AND '".$parametros->hasta."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]." ocb.created_at <= '".$parametros->fecha_reporte."'";
        }

        return DB::select($sql);
   }

   public static function reporteOCGeneral($parametros){
        $sql = "SELECT oc.orden_compra, r.requisicion, u.nombre, u.ccg, p.nombre AS proveedor, p.rfc, (SELECT SUM((((ocb.cantidad * ocb.precio) * .16) + (ocb.cantidad * ocb.precio))) FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = oc.id AND ocb.proveedor_id = p.id AND ocb.estatus = 1 OR ocb.estatus = 3) AS total, CASE WHEN (SELECT COUNT(cc.id) FROM cancelar_compras AS cc WHERE cc.orden_compra_id = oc.id AND cc.proveedor_id = p.id) != 0 THEN 'CANCELADA' WHEN (SELECT COUNT(rc.id) FROM rechazar_compras AS rc WHERE rc.orden_compra_id = oc.id AND rc.proveedor_id = p.id) != 0 THEN 'RECHAZADA' WHEN (SELECT oce.finalizada FROM orden_compra_estatuses AS oce WHERE oce.orden_compra_id = oc.id AND oce.proveedor_id = p.id) = 2 THEN 'FINALIZADA' ELSE 'EN PROCESO' END AS estatus, (SELECT string_agg(CASE WHEN substring(ocb.cabms, 1, 1) = '1' THEN '1000' WHEN substring(ocb.cabms, 1, 1) = '2' THEN '2000' WHEN substring(ocb.cabms, 1, 1) = '3' THEN '3000' WHEN substring(ocb.cabms, 1, 1) = '4' THEN '4000' WHEN substring(ocb.cabms, 1, 1) = '5' THEN '5000' END, ',') FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = oc.id) AS capitulo, TO_CHAR(oc.created_at, 'DD/MM/YYYY') AS fecha_creacion
            FROM orden_compras AS oc 
            JOIN requisiciones AS r on oc.requisicion_id = r.id 
            JOIN urgs AS u ON oc.urg_id = u.id 
            JOIN orden_compra_proveedors AS ocp ON oc.id = ocp.orden_compra_id 
            JOIN proveedores AS p ON ocp.proveedor_id = p.id";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 0;

        if($parametros->urg != ""){
            $sql .= " ".$condicion[$contador]." u.id = ".$parametros->urg;
            $contador = 1;
        }
        if($parametros->proveedor != ""){
            $sql .= " ".$condicion[$contador]." p.id = ".$parametros->proveedor;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from oc.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio){
                $sql .= " ".$condicion[$contador]." oc.created_at <= '".$parametros->fecha_reporte."'";    
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." oc.created_at BETWEEN '".$parametros->de."' AND '".$parametros->hasta."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]." oc.created_at <= '".$parametros->fecha_reporte."'";
        }
        
        return DB::select($sql);
   }

   public static function reporteCabmsCM($parametros){
        $sql = "SELECT substring(cp.partida,1,4) AS partida, substring(cp.capitulo,1,4) AS capitulo, cp.cabms, cm.numero_cm, cm.nombre_cm, pfp.descripcion_producto, pfp.precio_unitario, p.nombre AS proveedor, TO_CHAR(pfp.created_at,'DD/MM/YYYY') AS fecha_creacion
            FROM proveedores_fichas_productos AS pfp
            JOIN cat_productos AS cp ON pfp.producto_id = cp.id
            JOIN proveedores AS p ON pfp.proveedor_id = p.id
            JOIN contratos_marcos AS cm ON cp.contrato_marco_id = cm.id";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 0;

        if($parametros->contrato != ""){
            $sql .= " ".$condicion[$contador]." cm.id = ".$parametros->contrato;
            $contador = 1;
        }
        if($parametros->proveedor != ""){
            $sql .= " ".$condicion[$contador]." p.id = ".$parametrosproveedor;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from pfp.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio){
                $sql .= " ".$condicion[$contador]." pfp.created_at <= '".$parametros->fecha_reporte."'";    
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." pfp.created_at BETWEEN '".$parametros['de']."' AND '".$parametros['hasta']."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]." pfp.created_at <= '".$parametros->fecha_reporte."'";
        }

        return DB::select($sql);
   }

   public static function reporteProCM($parametros){
        $sql = "SELECT substring(cp.partida,1,4) AS partida, cp.cabms, substring(cp.capitulo,1,4) AS capitulo, TO_CHAR(pfp.created_at,'DD/MM/YYYY') AS fecha_publicacion, CASE WHEN pfp.validacion_precio = true THEN 'SI' ELSE 'NO' END AS validacion_economica, CASE WHEN pfp.validacion_administracion = true THEN 'SI' ELSE 'NO' END AS validacion_administrativa, CASE WHEN pfp.validacion_tecnica = true THEN 'SI' ELSE 'NO' END AS validacion_tecnica, cm.nombre_cm, cm.numero_cm, CASE WHEN pfp.estatus = true THEN 'DISPONIBLE' ELSE 'NO DISPONIBLE' END AS estatus, p.nombre AS proveedor, pfp.precio_unitario, (pfp.precio_unitario * .16) AS precio_iva, cp.medida, pfp.descripcion_producto, TO_CHAR(pfp.updated_at,'DD/MM/YYYY') AS fecha_update, cp.numero_ficha, cp.version
            FROM proveedores_fichas_productos AS pfp
            JOIN proveedores AS p ON pfp.proveedor_id = p.id
            JOIN cat_productos AS cp ON pfp.producto_id = cp.id
            JOIN contratos_marcos AS cm ON cp.contrato_marco_id = cm.id";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 0;

        if($parametros->contrato != ""){
            $sql .= " ".$condicion[$contador]." cm.id = ".$parametros->contrato;
            $contador = 1;
        }
        if($parametros->proveedor != ""){
            $sql .= " ".$condicion[$contador]." p.id = ".$parametrosproveedor;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from pfp.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio){
                $sql .= " ".$condicion[$contador]." pfp.created_at <= '".$parametros->fecha_reporte."'";    
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." pfp.created_at BETWEEN '".$parametros->de."' AND '".$parametros->hasta."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]." pfp.created_at <= '".$parametros->fecha_reporte."'";
        }

        return DB::select($sql);
   }

   public static function reporteProrroga($parametros){
        $sql = "SELECT ocp.id_prorroga, p.nombre, p.rfc, oc.orden_compra, CASE WHEN ocp.estatus IS NULL THEN 'EN PROCESO' WHEN ocp.estatus = 1 THEN 'ACEPTADA' ELSE 'RECHAZADA' END AS estatus , ocp.descripcion, TO_CHAR(ocp.fecha_solicitud, 'DD/MM/YYYY') AS fecha_solicitud, ocp.justificacion, ocp.dias_solicitados
            FROM orden_compra_prorrogas AS ocp 
            JOIN orden_compras AS oc ON ocp.orden_compra_id = oc.id
            JOIN proveedores AS p ON ocp.proveedor_id = p.id";

        $condicion = [0 => 'WHERE', 1 => 'AND'];
        $contador = 0;

        if($parametros->urg != ""){
            $sql .= " ".$condicion[$contador]." ocp.urg_id = ".$parametros->urg;
            $contador = 1;
        }
        if($parametros->proveedor != ""){
            $sql .= " ".$condicion[$contador]." p.id = ".$parametros->proveedor;
            $contador = 1;
        }
        if($parametros->anio != null && $parametros->trimestre == null){
            $sql .= " ".$condicion[$contador]." extract(year from ocp.created_at) = ".$parametros->anio;
            $contador = 1;
            if($parametros->mismo_anio){
                $sql .= " ".$condicion[$contador]." ocp.created_at <= '".$parametros->fecha_reporte."'";    
            }
        }
        if($parametros->de != null && $parametros->hasta != null){
            $sql .= " ".$condicion[$contador]." ocp.created_at BETWEEN '".$parametros->de."' AND '".$parametros->hasta."'";
        }
        if($parametros->de == null && $parametros->hasta == null && $parametros->anio == null){
            $sql .= " ".$condicion[$contador]." ocp.created_at <= '".$parametros->fecha_reporte."'";
        }

        return DB::select($sql);
   }


}
