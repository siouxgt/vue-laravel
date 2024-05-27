<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CatProducto extends Model
{
    use HasFactory;

    public function contratoMarco()
    {
        return $this->belongsTo('App\Models\ContratoMarco', 'contrato_marco_id');
    }

    public function validacionTecnica()
    {
        return $this->belongsTo('App\Models\ValidacionesTecnicas', 'validacion_id');
    }

    public function fichaProducto(){
        return $this->hasMany(ProveedorFichaProducto::class);
    }

    public static function ultimo()
    {
        return DB::select("SELECT id FROM cat_productos ORDER BY id DESC LIMIT 1");
    }

    public static function allCatProductos()
    {
        return DB::select("SELECT cp.id, cp.cabms, cp.descripcion, cp.numero_ficha, cp.version,  CASE WHEN cp.estatus = true THEN 'Activo' ELSE 'Inactivo' END AS estatus, cm.nombre_cm FROM cat_productos AS cp JOIN contratos_marcos AS cm ON cp.contrato_marco_id = cm.id");
    }

    public static function allCatProductosFull($id)
    {
        return DB::select("SELECT cp.id, cm.nombre_cm, cp.cabms, cp.descripcion, cp.version FROM cat_productos AS cp 
                            JOIN contratos_marcos AS cm ON cp.contrato_marco_id = cm.id 
                            JOIN expedientes_contratos_marcos AS ex ON ex.contrato_id = cm.id 
                            JOIN habilitar_proveedores AS hp ON hp.expediente_id = ex.id 
                            JOIN proveedores AS p ON hp.proveedor_id = p.id 
                            WHERE p.id = ".$id." AND hp.habilitado = true AND cp.estatus = true AND cp.habilitado = true GROUP BY cp.id, cm.nombre_cm, cp.cabms, cp.descripcion, cp.version");
    }

    public static function catFichaProducto($idCP){
        return DB::select("SELECT cp.id, cp.validacion_tecnica, cp.cabms AS elidproducto, cp.nombre_corto, cm.numero_cm, cm.nombre_cm, cp.numero_ficha, cp.version, cp.capitulo, cp.partida, cp.cabms,cp.descripcion, cp.especificaciones, cp.archivo_ficha_tecnica, hp.fecha_carga 
                                    FROM cat_productos AS cp
                                    JOIN contratos_marcos AS cm ON cp.contrato_marco_id = cm.id
                                    JOIN habilitar_productos AS hp ON hp.cat_producto_id = cp.id
                                    WHERE cp.habilitado = true AND cp.contrato_marco_id = cm.id
                                    AND cp.id = $idCP");
    }

    public static function productosContratoM($cmId = 0, $requisicion = 0)
    { //Función que consulta los productos dados de alta tomando en cuenta el contrato en el que estan dados de alta
        $extra = "";
        $porRequisicion = "";
        if ($cmId != 0) {
            $extra .= " AND cm.id = $cmId ";
        }
        if($requisicion){
            $porRequisicion .= " AND catp.cabms IN ".$requisicion." ";
        }

        $sql = "SELECT DISTINCT(catp.id), catp.cabms, catp.descripcion, 
                    (SELECT COUNT(*) 
                        FROM proveedores_fichas_productos AS pfp
                        JOIN cat_productos AS catp2 ON pfp.producto_id = catp2.id
                        JOIN contratos_marcos AS cm ON catp2.contrato_marco_id = cm.id
                        WHERE pfp.estatus = true
                        AND pfp.publicado = true
                        AND pfp.deleted_at IS NULL   
                        AND catp2.cabms = catp.cabms
                        $extra                   
                    ) AS total
                FROM proveedores_fichas_productos AS pfp
                JOIN cat_productos AS catp ON pfp.producto_id = catp.id
                JOIN contratos_marcos AS cm ON catp.contrato_marco_id = cm.id
                WHERE pfp.estatus = true
                AND pfp.publicado = true
                AND pfp.deleted_at IS NULL
                $extra
                $porRequisicion";

        $consulta = DB::select($sql);
        
        return $consulta;
    }

    public static function enUso($id){
        return DB::select('SELECT count(cp.id) FROM cat_productos AS cp JOIN habilitar_productos AS hp ON hp.cat_producto_id = cp.id WHERE hp.precio_maximo IS NOT NULL AND cp.id = '.$id);
    }

    public static function totalFormulariosActivos($proveedorId){
        return DB::select("SELECT count(cp.id) AS total FROM cat_productos cp JOIN habilitar_productos AS hpd ON hpd.cat_producto_id = cp.id JOIN contratos_marcos AS cm ON cp.contrato_marco_id = cm.id JOIN habilitar_proveedores AS hpv ON hpv.contrato_id = cm.id WHERE hpv.proveedor_id = $proveedorId");
    }
}
