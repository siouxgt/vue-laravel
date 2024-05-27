<?php

namespace App\Models;

use App\Traits\HashIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContratoMarco extends Model
{
    use HasFactory, HashIdTrait;

    protected $table = "contratos_marcos";
    protected $fillable = [
        'numero_cm',
        'nombre_cm',
        'objetivo',
        'f_inicio',
        'f_fin',
        'urg_id',
        'user_id_responsable',
        'capitulo_partida',
        'compras_verdes',
        'validacion_tecnica',
        'validaciones_seleccionadas',
        'sector',
        'estatus'
    ];
     
    protected $casts = [
        'f_inicio' => 'date:d/m/Y',
        'f_fin' => 'date:d/m/Y'
    ];
    
    //Relación muchos a muchos inverso

    public function urg()
    {
        return $this->belongsTo(Urg::class);
    }

    public function catProducto(){
        return $this->hasMany(CatProducto::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id_responsable');
    }

    public function contratosUrg(){
        return $this->hasMany(ContratoMarcoUrg::class);
    }

    public static function vigentes(){
        return  DB::select("SELECT cm.id, cm.nombre_cm, cm.created_at, cm.imagen, cm.porcentaje, (SELECT CONCAT(substring(u.nombre,1,1), substring(u.primer_apellido,1,1))  FROM users AS u WHERE u.id = cm.user_id_creo) AS usercreo, cm.updated_at, (SELECT count(hp.id) FROM habilitar_proveedores AS hp WHERE hp.contrato_id = cm.id) AS proveedores, (SELECT count(hp.id) FROM habilitar_productos AS hp JOIN cat_productos AS cp ON hp.cat_producto_id = cp.id WHERE hp.precio_maximo IS NOT NULL and cp.contrato_marco_id = cm.id) AS productos FROM contratos_marcos AS cm WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 180");

    }

    public static function porLiberar(){
        return DB::select("SELECT cm.id, cm.nombre_cm, cm.created_at, cm.imagen, cm.porcentaje, (SELECT CONCAT(substring(u.nombre,1,1), substring(u.primer_apellido,1,1))  FROM users AS u WHERE u.id = cm.user_id_creo) AS usercreo, cm.updated_at, (SELECT count(hp.id) FROM habilitar_proveedores AS hp WHERE hp.contrato_id = cm.id) AS proveedores, (SELECT count(hp.id) FROM habilitar_productos AS hp JOIN cat_productos AS cp ON hp.cat_producto_id = cp.id WHERE hp.precio_maximo IS NOT NULL and cp.contrato_marco_id = cm.id) AS productos FROM contratos_marcos AS cm WHERE cm.liberado = false AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 180");
    }

    public static function porVencer(){
        return DB::select("SELECT cm.id, cm.nombre_cm, cm.created_at, cm.imagen, cm.porcentaje, (SELECT CONCAT(substring(u.nombre,1,1), substring(u.primer_apellido,1,1))  FROM users AS u WHERE u.id = cm.user_id_creo) AS usercreo, cm.updated_at, (SELECT count(hp.id) FROM habilitar_proveedores AS hp WHERE hp.contrato_id = cm.id) AS proveedores, (SELECT count(hp.id) FROM habilitar_productos AS hp JOIN cat_productos AS cp ON hp.cat_producto_id = cp.id WHERE hp.precio_maximo IS NOT NULL and cp.contrato_marco_id = cm.id) AS productos FROM contratos_marcos AS cm WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) < 180 AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1");   
    }

    public static function vencidos(){
        return DB::select("SELECT cm.id, cm.nombre_cm, cm.created_at, cm.imagen, cm.porcentaje, cm.updated_at, (SELECT count(hp.id) FROM habilitar_proveedores AS hp WHERE hp.contrato_id = cm.id) AS proveedores, (SELECT CONCAT(substring(u.nombre,1,1), substring(u.primer_apellido,1,1))  FROM users AS u WHERE u.id = cm.user_id_creo) AS usercreo, (SELECT count(hp.id) FROM habilitar_productos AS hp JOIN cat_productos AS cp ON hp.cat_producto_id = cp.id WHERE hp.precio_maximo IS NOT NULL and cp.contrato_marco_id = cm.id) AS productos FROM contratos_marcos AS cm WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) < 1");
    }

    public static function countProveedores($contrato_id){
        $contrato_id = $this->hashDecode($contrato_id);
        return DB::select('SELECT count(hp.id) FROM habilitar_proveedores AS hp JOIN contratos_marco AS cm ON hp.contrato_id = cm.id WHERE hp.contrato_id = '. $contrato_id);

    }

    public static function contratosHabilitadosUrg($urg_id){
        return DB::select('SELECT cm.id, cm.nombre_cm, cm.created_at, cm.imagen,  cm.updated_at FROM contratos_marcos AS cm JOIN contratos_marcos_urgs AS cmu ON cm.id = cmu.contrato_marco_id WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1 AND cmu.estatus = true AND cmu.urg_id = '.$urg_id);
    }

    public static function contratosNoHabilitadosUrg($urg_id){
        return DB::select('SELECT cm.id, cm.nombre_cm, cm.created_at, cm.imagen,  cm.updated_at FROM contratos_marcos AS cm JOIN contratos_marcos_urgs AS cmu ON cm.id = cmu.contrato_marco_id WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1 AND cmu.estatus = false AND cmu.urg_id  = '.$urg_id);   
    }

    public static function contratosNoParticipaUrg($urg_id){
       return DB::select('SELECT cm.id, cm.nombre_cm, cm.created_at, cm.imagen, cm.updated_at FROM contratos_marcos AS cm WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1 AND cm.id NOT IN (SELECT cmu.contrato_marco_id  FROM contratos_marcos_urgs AS cmu WHERE cmu.urg_id = '.$urg_id.')');
    }

    public static function totalContratosProveedor($proveedorId){
        return DB::select("SELECT count(cm.id) AS total FROM contratos_marcos cm JOIN expedientes_contratos_marcos AS exp ON exp.contrato_id = cm.id JOIN habilitar_proveedores AS hap ON hap.expediente_id = exp.id WHERE hap.proveedor_id = $proveedorId");
    }

    public static function contratosHabilitadosProveedor($proveedorId){
        return DB::select('SELECT cm.id, cm.nombre_cm, cm.created_at, cm.imagen, cm.updated_at FROM contratos_marcos AS cm JOIN habilitar_proveedores AS hp ON cm.id = hp.contrato_id WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1 AND hp.habilitado = true AND hp.proveedor_id = ' . $proveedorId);
    }

    public static function contratosNoHabilitadosProveedor($proveedorId){
        return DB::select('SELECT cm.id, cm.nombre_cm, cm.created_at, cm.imagen, cm.updated_at FROM contratos_marcos AS cm JOIN habilitar_proveedores AS hp ON cm.id = hp.contrato_id WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1 AND hp.habilitado = false AND hp.proveedor_id = ' . $proveedorId);
    }

    public static function contratosNoParticipaProveedor($proveedorId){
       return DB::select('SELECT cm.id, cm.nombre_cm, cm.created_at, cm.imagen, cm.updated_at FROM contratos_marcos AS cm WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1 AND cm.id NOT IN (SELECT hp.contrato_id  FROM habilitar_proveedores AS hp WHERE hp.proveedor_id = ' . $proveedorId . ')');
    }

    public static function contratosHomeUrg($urg_id){
        return DB::select("SELECT cm.id, cm.nombre_cm, cm.capitulo_partida, cm.imagen FROM contratos_marcos AS cm JOIN contratos_marcos_urgs AS cmu ON cmu.contrato_marco_id = cm.id WHERE cmu.urg_id = ".$urg_id." AND cm.liberado = true ORDER BY cm.id DESC LIMIT 4");
    }

    public static function contratosProductos(){
         return  DB::select("SELECT cm.id, cm.nombre_cm, (SELECT COUNT(pfp.id) FROM proveedores_fichas_productos AS pfp JOIN cat_productos AS cp ON pfp.producto_id = cp.id WHERE cp.contrato_marco_id = cm.id AND pfp.estatus = true AND pfp.publicado = true AND pfp.deleted_at IS NULL) AS total FROM contratos_marcos AS cm WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1");
    }

}