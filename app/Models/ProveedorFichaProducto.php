<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProveedorFichaProducto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "proveedores_fichas_productos";
    //protected $fillable=[];

    protected $casts = [
        'updated_at' => 'date:d/m/Y',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function catProducto()
    {
        return $this->belongsTo(CatProducto::class, 'producto_id');
    }

    public static function siguienteId()
    {
        $consulta = DB::select("SELECT max(id) AS maximo FROM proveedores_fichas_productos WHERE deleted_at IS NULL");
        return ($consulta[0]->maximo) + 1;
    }

    public static function allProveedorFichaProducto($id)
    {
        $sql = "SELECT pfp.id, catp.nombre_corto, catp.validacion_tecnica, catp.archivo_ficha_tecnica, pfp.id_producto, cm.numero_cm, cm.nombre_cm, catp.numero_ficha, catp.medida, 
                    pfp.version, catp.capitulo, catp.partida, catp.cabms, catp.descripcion, pfp.caracteristicas, pfp.estatus_inicio,
                    pfp.nombre_producto, pfp.descripcion_producto, pfp.foto_uno, pfp.foto_dos, pfp.foto_tres, pfp.foto_cuatro, 
                    pfp.foto_cinco, pfp.foto_seis, pfp.estatus_producto,
                    pfp.doc_ficha_tecnica, pfp.doc_adicional_uno, pfp.doc_adicional_dos, pfp.doc_adicional_tres, pfp.estatus_ficha_tec,
                    pfp.marca, pfp.modelo, pfp.material, pfp.composicion, pfp.tamanio, pfp.color, pfp.dimensiones, pfp.sku, 
                    pfp.fabricante, pfp.pais_origen, pfp.grado_integracion_nacional, pfp.presentacion, pfp.disenio,
                    pfp.acabado, pfp.forma, pfp.aspecto, pfp.etiqueta, pfp.envase, pfp.empaque, pfp.estatus_inicio, pfp.estatus_caracteristicas,
                    pfp.tiempo_entrega, pfp.temporalidad, pfp.documentacion_incluida, pfp.estatus_entrega,
                    pfp.precio_unitario, pfp.unidad_minima_venta, pfp.stock, pfp.vigencia, pfp.estatus_precio,
                    pfp.validacion_tecnica_prueba, pfp.estatus_validacion_tec, p.nombre, p.imagen,
                    pfp.updated_at,
                    hp.fecha_carga
                FROM proveedores_fichas_productos AS pfp JOIN cat_productos AS catp ON catp.id = pfp.producto_id JOIN habilitar_productos AS hp ON hp.cat_producto_id = catp.id JOIN contratos_marcos AS cm ON cm.id = catp.contrato_marco_id JOIN proveedores AS p ON pfp.proveedor_id = p.id
                WHERE pfp.deleted_at IS NULL AND pfp.id = $id";
        return DB::select($sql);
    }

    public static function productoTiendaUrgShow($idPFP, $idUrg)
    {
        $sql = "SELECT pfp.id, p.id AS proveedor_id, catp.nombre_corto, cm.nombre_cm, catp.medida, 
                     catp.cabms, pfp.nombre_producto, pfp.descripcion_producto, pfp.foto_uno, pfp.foto_dos, pfp.foto_tres, pfp.foto_cuatro, pfp.foto_cinco, pfp.foto_seis,
                    pfp.doc_ficha_tecnica, pfp.doc_adicional_uno, pfp.doc_adicional_dos, pfp.doc_adicional_tres, pfp.marca, pfp.modelo, pfp.material, pfp.composicion, pfp.tamanio, pfp.color, pfp.dimensiones, pfp.sku, pfp.fabricante, pfp.pais_origen, pfp.grado_integracion_nacional, pfp.presentacion, pfp.disenio, pfp.acabado, pfp.forma, pfp.aspecto, pfp.etiqueta, pfp.envase, pfp.empaque, pfp.tiempo_entrega, pfp.temporalidad, pfp.documentacion_incluida, pfp.precio_unitario, pfp.unidad_minima_venta, pfp.stock, pfp.vigencia, p.nombre AS nombre_prove, p.imagen AS imagen_prove, ((now() - pfp.created_at) < '90 days') AS nuevo, (SELECT sum(cc.cantidad_producto) AS cantidad_producto FROM carritos_compras AS cc JOIN requisiciones AS req ON cc.requisicion_id = req.id WHERE req.urg_id = $idUrg AND cc.proveedor_ficha_producto_id = pfp.id AND cc.comprado = 0),
                    (SELECT id AS id_favorito FROM productos_favoritos_urg WHERE proveedor_ficha_producto_id = $idPFP AND urg_id = $idUrg AND deleted_at IS NULL), (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) AS calificacion, (SELECT COUNT(ocep.id) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) AS total_evaluaciones, (SELECT SUM(ocepr.general) FROM orden_compra_evaluacion_proveedors AS ocepr WHERE ocepr.proveedor_id = p.id) AS calificacion_proveedor, (SELECT COUNT(ocepr.id) FROM orden_compra_evaluacion_proveedors AS ocepr WHERE ocepr.proveedor_id = p.id) AS total_evaluaciones_proveedor
                FROM proveedores_fichas_productos AS pfp
                JOIN cat_productos AS catp  ON pfp.producto_id = catp.id
                JOIN contratos_marcos AS cm ON catp.contrato_marco_id = cm.id 
                JOIN proveedores AS p ON pfp.proveedor_id = p.id
                WHERE pfp.id = $idPFP";
                
        return DB::select($sql);
    }

    public static function carruselTiendaShow($cabms){
        return DB::select("SELECT pfp.id, catp.medida, catp.cabms, pfp.nombre_producto, pfp.foto_uno, pfp.foto_dos, pfp.foto_tres, pfp.foto_cuatro, pfp.foto_cinco, pfp.foto_seis,
                    pfp.marca, pfp.precio_unitario, p.nombre AS nombre_prove, ((now() - pfp.created_at) < '90 days') AS nuevo
                FROM proveedores_fichas_productos AS pfp
                JOIN cat_productos AS catp  ON pfp.producto_id = catp.id
                JOIN proveedores AS p ON pfp.proveedor_id = p.id
                WHERE pfp.deleted_at IS NULL AND pfp.publicado = true AND catp.cabms LIKE '%".$cabms."%' LIMIT 12");
    }

    public static function cargarDimensiones($id)
    {
        $sql = "SELECT pfp.id, pfp.dimensiones FROM proveedores_fichas_productos AS pfp JOIN cat_productos AS catp ON catp.id = pfp.producto_id JOIN contratos_marcos AS cm ON cm.id = catp.contrato_marco_id WHERE pfp.deleted_at IS NULL AND pfp.id = $id";
        return DB::select($sql);
    }

    public static function cargarColores($id)
    {
        return DB::select("SELECT pfp.id, pfp.color FROM proveedores_fichas_productos AS pfp JOIN cat_productos AS catp ON catp.id = pfp.producto_id JOIN contratos_marcos AS cm ON cm.id = catp.contrato_marco_id AND pfp.deleted_at IS NULL AND pfp.id = $id");
    }

    public static function allProductosProveedor($proveedorId, $productoId, $filtro = '')
    {
        $sql = "SELECT pfp.id, pfp.proveedor_id, pfp.id_producto, catp.nombre_corto, catp.cabms, pfp.nombre_producto, pfp.estatus, pfp.marca, pfp.tamanio, pfp.precio_unitario, catp.medida, pfp.foto_uno, pfp.foto_dos, pfp.foto_tres, pfp.foto_cuatro, pfp.foto_cinco, pfp.foto_seis, pfp.estatus_producto, pfp.estatus_ficha_tec, pfp.validacion_precio, pfp.validacion_administracion, pfp.validacion_tecnica, pfp.publicado, pfp.validacion_cuenta, pfp.estatus_validacion_tec, cm.nombre_cm, cm.numero_cm, (SELECT count(ppr.id) FROM productos_preguntas_respuestas AS ppr WHERE ppr.proveedor_ficha_producto_id = pfp.id AND ppr.respuesta IS NULL) AS numero_preguntas FROM proveedores_fichas_productos AS pfp JOIN cat_productos AS catp ON catp.id = pfp.producto_id JOIN contratos_marcos AS cm ON cm.id = catp.contrato_marco_id WHERE pfp.proveedor_id = $proveedorId AND pfp.deleted_at IS NULL";

        if ($productoId != '') $sql .= " AND pfp.producto_id = $productoId";
        if ($filtro != '') {
            if ($filtro == 'revision') $sql .= " AND pfp.validacion_precio IS NOT NULL AND pfp.publicado = false";
            if ($filtro == 'publicados') $sql .= " AND pfp.publicado = true";
            if ($filtro == 'concluir') $sql .= " AND pfp.validacion_precio IS NULL AND pfp.validacion_administracion IS NULL";
            if ($filtro == 'bloqueo') $sql .= " AND pfp.validacion_precio = false AND pfp.validacion_cuenta = 3";
            if ($filtro == 'rechazadas') $sql .= " AND (pfp.validacion_precio = false OR pfp.validacion_administracion = false OR pfp.validacion_tecnica = false)";
        }
        $sql .= " ORDER BY pfp.id";
        return DB::select($sql);
    }

    public static function obtenerNombreContratoMarco($catProductoId)
    { //Obtener el nombre del contrato marco por medio de la id del catalogo de producto
        $sql = "SELECT cm.nombre_cm, cm.numero_cm FROM contratos_marcos AS cm JOIN cat_productos AS cp ON cp.contrato_marco_id = cm.id WHERE cp.id = $catProductoId";
        return DB::select($sql);
    }

    public static function allProductosProveedorTiendaU($filtro = "")
    { //Consultar los productos que ya este completamente validado y publicado. Tambien se toma en cuenta si la id de la URG tiene permiso de ver los productos.               
        $sql = "SELECT pfp.id, catp.descripcion, catp.cabms, pfp.nombre_producto, pfp.marca, pfp.tamanio, pfp.precio_unitario, catp.medida, pfp.foto_uno, pfp.foto_dos, pfp.foto_tres, pfp.foto_cuatro, pfp.foto_cinco, pfp.foto_seis, 
                    ((now() - pfp.created_at) < '90 days') AS dias, 
                    (SELECT id FROM productos_favoritos_urg WHERE proveedor_ficha_producto_id = pfp.id) AS id_favorito,
                    (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) AS calificacion, (SELECT COUNT(ocep.id) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) AS total_evaluaciones, CASE WHEN (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) IS NULL THEN 0 ELSE (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id)/(SELECT COUNT(ocep.id) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) END estrellas, p.nombre AS proveedor
                FROM proveedores_fichas_productos AS pfp
                JOIN cat_productos AS catp ON pfp.producto_id = catp.id
                JOIN proveedores AS p ON pfp.proveedor_id = p.id
                JOIN contratos_marcos AS cm ON catp.contrato_marco_id = cm.id
                " . ProveedorFichaProducto::buscarFiltroFavoritos($filtro) . "
                WHERE pfp.estatus = true
                AND pfp.publicado = true
                AND pfp.deleted_at IS NULL";
        if ($filtro != "") {
            $sql .= ProveedorFichaProducto::desglosarFiltro($filtro);
        }

        return DB::select($sql);
    }

    public static function buscarFiltroFavoritos($filtro)
    {
        if ($filtro != "") {
            $filtro = json_decode($filtro);

            if ($filtro->favoritos != '') {
                $filtro->favoritos = ''; //Vaciamos el filtro para evitar que vuelva a entrar aqui en la segunda pasada
                return " JOIN productos_favoritos_urg AS profu ON pfp.id = profu.proveedor_ficha_producto_id";
            }
        }
    }
    public static function desglosarFiltro($filtro)
    {
        $filtro = json_decode($filtro);
        $desgloce = '';

        if ($filtro->cm != '') {
            $desgloce .= " AND cm.id = $filtro->cm";
        }
        if ($filtro->requisicion != '') {
            $desgloce .= " AND catp.cabms IN $filtro->requisicion";
        }
        if ($filtro->cabms != '') {
            $desgloce .= " AND catp.cabms = '$filtro->cabms'";
        }
        if ($filtro->tamanio != '') {
            $desgloce .= " AND LOWER(pfp.tamanio) = LOWER('$filtro->tamanio')";
        }
        if ($filtro->precio != '') {
            $desgloce .= " AND pfp.precio_unitario = $filtro->precio";
        }
        if ($filtro->entrega != '') {
            $desgloce .= " AND pfp.tiempo_entrega = $filtro->entrega";
        }
        if ($filtro->temporalidad != '') {
            $desgloce .= " AND pfp.temporalidad = '$filtro->temporalidad'";
        }
        if ($filtro->empresa != '') {
            $desgloce .= " AND p.nombre = '$filtro->empresa'";
        }
        if ($filtro->buscado != '') { //LOWER(campo) LIKE LOWER
            $desgloce .= " AND (UPPER(pfp.nombre_producto) LIKE UPPER('%$filtro->buscado%') OR UPPER(p.nombre) LIKE UPPER('%$filtro->buscado%') OR UPPER(catp.descripcion) LIKE UPPER('%$filtro->buscado%') OR catp.cabms LIKE '%$filtro->buscado%' OR UPPER(pfp.marca) LIKE UPPER('%$filtro->buscado%'))";
        }
        if ($filtro->orden != '') {
            if ($filtro->orden == 'nuevos') { //Filtro que permite mostrar los productos registrados en un lapso no mayor a 90 días
                $desgloce .= " AND (now() - pfp.created_at) < '90 days' ORDER BY pfp.created_at ASC";
            } elseif ($filtro->orden == 'bajo') {
                $desgloce .= " ORDER BY pfp.precio_unitario ASC";
            } elseif ($filtro->orden == 'alto') {
                $desgloce .= " ORDER BY pfp.precio_unitario DESC";
            } elseif ($filtro->orden == 'estrellas' ){
                $desgloce.= " ORDER BY estrellas DESC";
            }
        }
        return $desgloce;
    }

    public static function cargarFiltroTamanios($filtro)
    { //Filtros que se usarán: cm (contrato marco)
        $sql = "SELECT DISTINCT ON (upper(pfp.tamanio)) tamanio
                FROM proveedores_fichas_productos AS pfp
                JOIN cat_productos AS catp ON pfp.producto_id = catp.id
                JOIN proveedores AS p ON pfp.proveedor_id = p.id
                JOIN contratos_marcos AS cm ON catp.contrato_marco_id = cm.id
                " . ProveedorFichaProducto::buscarFiltroFavoritos($filtro) . "
                AND pfp.estatus = true AND pfp.publicado = true AND pfp.deleted_at IS NULL";

        if ($filtro != "") $sql .= ProveedorFichaProducto::desglosarFiltro($filtro);

        return DB::select($sql);
    }

    public static function cargarFiltroTiempoEntrega($filtro)
    {
        $sql = "SELECT DISTINCT pfp.tiempo_entrega, pfp.temporalidad 
                FROM proveedores_fichas_productos AS pfp
                JOIN cat_productos AS catp ON pfp.producto_id = catp.id
                JOIN proveedores AS p ON pfp.proveedor_id = p.id
                JOIN contratos_marcos AS cm ON catp.contrato_marco_id = cm.id
                " . ProveedorFichaProducto::buscarFiltroFavoritos($filtro) . "
                AND pfp.estatus = true AND pfp.publicado = true AND pfp.deleted_at IS NULL";

        if ($filtro != "") $sql .= ProveedorFichaProducto::desglosarFiltro($filtro);
        
        return DB::select($sql);
    }


    public static function countProveedorFP($id, $proveedor_id)
    { //Cuenta la cantidad de productos dados de alta tomando en cuenta su id que corresponde a CABMS único
        $sql = "SELECT count(pfp.producto_id) FROM proveedores_fichas_productos AS pfp WHERE pfp.producto_id = $id AND pfp.deleted_at IS NULL AND pfp.proveedor_id = $proveedor_id";
        return DB::select($sql);
    }

    public static function countFormulariosLlenos($contratoId)
    {
        return DB::select("SELECT fp.producto_id FROM proveedores_fichas_productos AS fp JOIN cat_productos AS cp ON fp.producto_id = cp.id WHERE cp.contrato_marco_id = " . $contratoId . " GROUP BY fp.producto_id");
    }

    public static function contadorEconomica($contratoId)
    {
        return DB::select("SELECT COUNT(fp.id) AS economica FROM proveedores_fichas_productos AS fp JOIN cat_productos AS cp ON fp.producto_id = cp.id  WHERE cp.contrato_marco_id = " . $contratoId . " AND fp.validacion_precio = true");
    }

    public static function contadorAdministrativa($contratoId)
    {
        return DB::select("SELECT COUNT(fp.id) AS administrativa FROM proveedores_fichas_productos AS fp JOIN cat_productos AS cp ON fp.producto_id = cp.id  WHERE cp.contrato_marco_id = " . $contratoId . " AND fp.validacion_administracion = true");
    }

    public static function contadorTecnica($contratoId)
    {
        return DB::select("SELECT COUNT(fp.id) AS tecnica FROM proveedores_fichas_productos AS fp JOIN cat_productos AS cp ON fp.producto_id = cp.id  WHERE cp.contrato_marco_id = " . $contratoId . " AND fp.validacion_tecnica = true");
    }

    public static function todos($contratoId)
    {
        return DB::select("SELECT COUNT(fp.id) AS todos FROM proveedores_fichas_productos AS fp JOIN cat_productos AS cp ON fp.producto_id = cp.id  WHERE cp.contrato_marco_id = " . $contratoId);
    }

    public static function contadorAdminTecnica($contratoId)
    {
        return DB::select("SELECT COUNT(fp.id) AS admin FROM proveedores_fichas_productos AS fp JOIN cat_productos AS cp ON fp.producto_id = cp.id  WHERE cp.contrato_marco_id = " . $contratoId . " AND fp.validacion_administracion = true");
    }

    public static function contadorSinTecnica($contratoId)
    {
        return DB::select("SELECT COUNT(fp.id) AS sintecnica FROM proveedores_fichas_productos AS fp JOIN cat_productos AS cp ON fp.producto_id = cp.id  WHERE cp.contrato_marco_id = " . $contratoId . " AND fp.validacion_administracion = true  and fp.validacion_tecnica IS NULL");
    }

    public static function contadorPublicados($contratoId)
    {
        return DB::select("SELECT COUNT(fp.id) AS publicados FROM proveedores_fichas_productos AS fp JOIN cat_productos AS cp ON fp.producto_id = cp.id  WHERE cp.contrato_marco_id = " . $contratoId . " AND fp.publicado = true");
    }

    public static function contadorNoPublicados($contratoId)
    {
        return DB::select("SELECT COUNT(fp.id) AS nopublicado FROM proveedores_fichas_productos AS fp JOIN cat_productos AS cp ON fp.producto_id = cp.id  WHERE cp.contrato_marco_id = " . $contratoId . " AND fp.publicado = false AND fp.validacion_precio = true AND fp.validacion_administracion = true AND (fp.validacion_tecnica = true OR fp.validacion_tecnica is NULL)");
    }

    public static function producto($catProdId)
    {
        return DB::select('SELECT fp.id, cp.cabms, fp.nombre_producto, fp.validacion_precio AS economica, fp.validacion_administracion AS administrativa, fp.validacion_tecnica AS tecnica, fp.publicado FROM proveedores_fichas_productos AS fp  JOIN cat_productos AS cp ON fp.producto_id = cp.id  WHERE fp.estatus = true AND fp.producto_id = ' . $catProdId);
    }

    public static function fichaProducto($id)
    {
        return DB::select("SELECT pfp.id, catp.nombre_corto, catp.validacion_tecnica AS cattecnica, catp.numero_ficha, catp.medida, pfp.version, catp.cabms, catp.descripcion, pfp.nombre_producto, pfp.descripcion_producto, pfp.foto_uno, pfp.foto_dos, pfp.foto_tres, pfp.foto_cuatro, pfp.foto_cinco, pfp.foto_seis, pfp.doc_ficha_tecnica, pfp.doc_adicional_uno, pfp.doc_adicional_dos,pfp.doc_adicional_tres, pfp.estatus_ficha_tec,pfp.marca, pfp.modelo, pfp.material, pfp.tamanio, pfp.color, pfp.dimensiones, pfp.sku, pfp.fabricante, pfp.grado_integracion_nacional, pfp.empaque, pfp.tiempo_entrega, pfp.temporalidad, pfp.precio_unitario, pfp.unidad_minima_venta, pfp.stock, pfp.vigencia, pfp.validacion_precio, pfp.validacion_administracion, pfp.validacion_tecnica AS fptecnica,pfp.publicado, pfp.documentacion_incluida, pfp.updated_at, pfp.created_at, p.nombre, p.imagen
            FROM proveedores_fichas_productos AS pfp
            JOIN cat_productos AS catp ON pfp.producto_id = catp.id 
            JOIN proveedores AS p ON pfp.proveedor_id = p.id
            WHERE pfp.id = " . $id . " AND pfp.estatus = true");
    }

    public static function validacionTecnica($urg)
    {
        return DB::select("SELECT fp.id, cm.nombre_cm, p.nombre, fp.nombre_producto, vt.siglas, cp.tipo_prueba, fp.validacion_tecnica_prueba, fp.validacion_tecnica FROM proveedores_fichas_productos AS fp JOIN cat_productos AS cp ON fp.producto_id = cp.id JOIN proveedores AS p ON fp.proveedor_id = p.id JOIN contratos_marcos AS cm ON cp.contrato_marco_id = cm.id JOIN validaciones_tecnicas AS vt ON cp.validacion_id = vt.id WHERE cp.validacion_tecnica = true AND vt.urg_id = " . $urg);
    }

    public static function allPrublicados()
    {
        return DB::select("SELECT COUNT(fp.id) AS publicados FROM proveedores_fichas_productos AS fp WHERE fp.publicado = true");
    }

    public static function allProductos()
    {
        return DB::select("SELECT COUNT(fp.id) AS productos FROM proveedores_fichas_productos AS fp");
    }

    public static function allValidacionTec()
    {
        return DB::select("SELECT COUNT(fp.id) AS productos FROM proveedores_fichas_productos AS fp WHERE fp.validacion_precio = true AND fp.validacion_administracion = true AND fp.validacion_tecnica <> true");
    }

    public static function estatusVerificaciones($proveedorId)
    {
        $sql = "SELECT 
                    (SELECT COUNT(pfp.id) AS total_revision FROM proveedores_fichas_productos pfp WHERE pfp.validacion_precio IS NOT NULL AND pfp.publicado = false AND pfp.proveedor_id = $proveedorId),
                    (SELECT COUNT(pfp.id) AS total_publicados FROM proveedores_fichas_productos pfp WHERE pfp.publicado = true AND pfp.proveedor_id = $proveedorId),
                    (SELECT COUNT(pfp.id) AS total_concluir FROM proveedores_fichas_productos pfp WHERE pfp.validacion_precio IS NULL AND pfp.validacion_administracion IS NULL AND pfp.proveedor_id = $proveedorId),
                    (SELECT COUNT(pfp.id) AS total_bloqueados FROM proveedores_fichas_productos pfp WHERE pfp.validacion_precio = false AND pfp.validacion_cuenta = 3 AND pfp.proveedor_id = $proveedorId),
                    (SELECT COUNT(pfp.id) AS total_rechazadas FROM proveedores_fichas_productos pfp WHERE (pfp.validacion_precio = false OR pfp.validacion_administracion = false OR pfp.validacion_tecnica = false) AND pfp.proveedor_id = $proveedorId)";
        return DB::select($sql);
    }

    public static function productosNuevos($urg_id){
        return DB::select("SELECT pfp.id, pfp.nombre_producto, pfp.marca, pfp.tamanio, pfp.precio_unitario, pfp.foto_uno, pfp.created_at, cp.medida, cp.cabms, cp.descripcion, CASE WHEN (SELECT pfu.id FROM productos_favoritos_urg AS pfu WHERE pfu.proveedor_ficha_producto_id = pfp.id AND pfu.urg_id = ".$urg_id.") IS NULL THEN false ELSE true END AS favorito, (SELECT SUM(ep.calificacion) FROM orden_compra_evaluacion_productos as ep WHERE ep.producto_id = pfp.id) AS calificacion, (SELECT COUNT(ep.id) FROM orden_compra_evaluacion_productos as ep WHERE ep.producto_id = pfp.id) AS total, (SELECT id AS id_favorito FROM productos_favoritos_urg  AS pfu WHERE pfu.proveedor_ficha_producto_id = pfp.id AND pfu.urg_id = ".$urg_id." AND deleted_at IS NULL) as id_favorito FROM  proveedores_fichas_productos AS pfp JOIN cat_productos AS cp ON pfp.producto_id = cp.id WHERE pfp.estatus = true AND pfp.publicado = true GROUP BY pfp.id, pfp.nombre_producto, pfp.marca, pfp.tamanio, pfp.precio_unitario, pfp.foto_uno, pfp.created_at, cp.medida, cp.cabms, cp.descripcion ORDER BY pfp.id DESC LIMIT 10");
    }

    public static function productoId($proveedor_id){
        return DB::select("SELECT CONCAT(pfp.id_producto,' - ', pfp.nombre_producto) AS origen FROM proveedores_fichas_productos AS pfp WHERE pfp.proveedor_id = ".$proveedor_id);
    }

    public static function allProductosAdmin($filtro){
        $sql = "SELECT pfp.id, catp.descripcion, catp.cabms, pfp.nombre_producto, pfp.marca, pfp.tamanio, pfp.precio_unitario, catp.medida, pfp.foto_uno, pfp.foto_dos, pfp.foto_tres, pfp.foto_cuatro, pfp.foto_cinco, pfp.foto_seis, 
                    ((now() - pfp.created_at) < '90 days') AS nuevo, 
                    (SELECT id FROM productos_favoritos_urg WHERE proveedor_ficha_producto_id = pfp.id) AS id_favorito,
                    (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) AS calificacion, (SELECT COUNT(ocep.id) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) AS total_evaluaciones, CASE WHEN (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) IS NULL THEN 0 ELSE (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id)/(SELECT COUNT(ocep.id) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) END estrellas, p.nombre AS proveedor
                FROM proveedores_fichas_productos AS pfp
                JOIN cat_productos AS catp ON pfp.producto_id = catp.id
                JOIN proveedores AS p ON pfp.proveedor_id = p.id
                JOIN contratos_marcos AS cm ON catp.contrato_marco_id = cm.id
                WHERE pfp.estatus = true
                AND pfp.publicado = true
                AND pfp.deleted_at IS NULL";
            $sql .= ProveedorFichaProducto::desglosarFiltro($filtro);
        
        return DB::select($sql);
    }

   public static function totalProductos($proveedor_id){
        return DB::select("SELECT count(pfp.producto_id) AS productos FROM proveedores_fichas_productos AS pfp WHERE pfp.deleted_at IS NULL AND pfp.publicado = true AND pfp.proveedor_id = ".$proveedor_id);
   }

   public static function productosAdmiContrato($cm){
        return DB::select("SELECT pfp.id, catp.descripcion, catp.cabms, pfp.nombre_producto, pfp.marca, pfp.tamanio, pfp.precio_unitario, catp.medida, pfp.foto_uno, pfp.foto_dos, pfp.foto_tres, pfp.foto_cuatro, pfp.foto_cinco, pfp.foto_seis, 
                    ((now() - pfp.created_at) < '90 days') AS nuevo, 
                    (SELECT id FROM productos_favoritos_urg WHERE proveedor_ficha_producto_id = pfp.id) AS id_favorito,
                    (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) AS calificacion, (SELECT COUNT(ocep.id) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) AS total_evaluaciones, CASE WHEN (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) IS NULL THEN 0 ELSE (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id)/(SELECT COUNT(ocep.id) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) END estrellas, p.nombre AS proveedor
                FROM proveedores_fichas_productos AS pfp
                JOIN cat_productos AS catp ON pfp.producto_id = catp.id
                JOIN proveedores AS p ON pfp.proveedor_id = p.id
                JOIN contratos_marcos AS cm ON catp.contrato_marco_id = cm.id
                WHERE pfp.estatus = true AND pfp.publicado = true AND pfp.deleted_at IS NULL AND catp.contrato_marco_id = ".$cm);
   }

    public static function productoTiendaAdminShow($idPFP)
    {
        $sql = "SELECT pfp.id, p.id AS proveedor_id, catp.nombre_corto, cm.nombre_cm, catp.medida, catp.cabms, catp.numero_ficha, catp.descripcion, catp.version, pfp.nombre_producto, pfp.descripcion_producto, pfp.foto_uno, pfp.foto_dos, pfp.foto_tres, pfp.foto_cuatro, pfp.foto_cinco, pfp.foto_seis, pfp.doc_ficha_tecnica, pfp.doc_adicional_uno, pfp.doc_adicional_dos, pfp.doc_adicional_tres, pfp.marca, pfp.modelo, pfp.material, pfp.composicion, pfp.tamanio, pfp.color, pfp.dimensiones, pfp.sku, pfp.fabricante, pfp.pais_origen, pfp.grado_integracion_nacional, pfp.presentacion, pfp.disenio, pfp.acabado, pfp.forma, pfp.aspecto, pfp.etiqueta, pfp.envase, pfp.empaque, pfp.tiempo_entrega, pfp.temporalidad, pfp.documentacion_incluida, pfp.precio_unitario, pfp.unidad_minima_venta, pfp.stock, pfp.vigencia, p.nombre AS nombre_prove, p.imagen AS imagen_prove, ((now() - pfp.created_at) < '90 days') AS nuevo, pfp.updated_at, pfp.created_at, (SELECT SUM(ocep.calificacion) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) AS calificacion, (SELECT COUNT(ocep.id) FROM orden_compra_evaluacion_productos AS ocep WHERE ocep.producto_id = pfp.id) AS total_evaluaciones, (SELECT SUM(ocepr.general) FROM orden_compra_evaluacion_proveedors AS ocepr WHERE ocepr.proveedor_id = p.id) AS calificacion_proveedor, (SELECT COUNT(ocepr.id) FROM orden_compra_evaluacion_proveedors AS ocepr WHERE ocepr.proveedor_id = p.id) AS total_evaluaciones_proveedor
                FROM proveedores_fichas_productos AS pfp
                JOIN cat_productos AS catp  ON pfp.producto_id = catp.id
                JOIN contratos_marcos AS cm ON catp.contrato_marco_id = cm.id 
                JOIN proveedores AS p ON pfp.proveedor_id = p.id
                WHERE pfp.id = $idPFP";
                
        return DB::select($sql);
    }
}
