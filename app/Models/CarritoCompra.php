<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CarritoCompra extends Model
{
    use HasFactory;

    protected $table = "carritos_compras";
    protected $fillable = [
        'requisicion_id',
        'proveedor_ficha_producto_id',
        'cantidad_producto',
        'color',
        'comprado'
    ];

    public function requisicion(){
        return $this->belongsTo(Requisicione::class);
    }

    public static function cantidadProductosCarrito($id)
    {
        $sql = "SELECT COUNT(*)
                FROM carritos_compras AS cc
                JOIN requisiciones AS req ON cc.requisicion_id = req.id
                WHERE req.urg_id = $id
                AND cc.comprado != 1";
                
        return DB::select($sql);
    }

    public static function comprobarProductoAgregado($idRequisicion, $idPfp)
    {
        $sql = "SELECT cc.id
                FROM carritos_compras AS cc
                    WHERE requisicion_id = $idRequisicion
                    AND proveedor_ficha_producto_id = $idPfp
                    AND cc.comprado != 1";

        return DB::select($sql);
    }

    public static function allProductosCarrito($id, $estadoCompra)
    {
        $sql = "SELECT cc.id, p.id AS proveedor_id_int, req.id AS requisicion_id_int, req.requisicion,
                        p.nombre, catp.cabms, catp.nombre_corto, pfp.marca, pfp.nombre_producto, pfp.tamanio,
                        cc.cantidad_producto, cc.color, pfp.precio_unitario, catp.medida, pfp.foto_uno, pfp.stock
                FROM carritos_compras AS cc
                JOIN requisiciones AS req ON cc.requisicion_id = req.id
                JOIN proveedores_fichas_productos AS pfp ON cc.proveedor_ficha_producto_id = pfp.id
                JOIN cat_productos AS catp ON pfp.producto_id = catp.id
                JOIN proveedores AS p ON pfp.proveedor_id = p.id
                WHERE req.urg_id = $id";

        if ($estadoCompra == 0) {
            $sql .= " AND cc.comprado != 1";
        } else {
            $sql .= " AND cc.comprado = $estadoCompra";
        }

        $sql .= " ORDER BY cc.id";
        
        return DB::select($sql);
    }

    public static function productosOrdenCompra($id,$productos)
    {

        return DB::select("SELECT cc.id, p.id AS proveedor_id_int, req.id AS requisicion_id_int, req.requisicion,
                        p.nombre, catp.cabms, catp.nombre_corto, pfp.marca, pfp.nombre_producto, pfp.tamanio,
                        cc.cantidad_producto, cc.color, pfp.precio_unitario, catp.medida, pfp.foto_uno, pfp.stock
                FROM carritos_compras AS cc
                JOIN requisiciones AS req ON cc.requisicion_id = req.id
                JOIN proveedores_fichas_productos AS pfp ON cc.proveedor_ficha_producto_id = pfp.id
                JOIN cat_productos AS catp ON pfp.producto_id = catp.id
                JOIN proveedores AS p ON pfp.proveedor_id = p.id
                WHERE cc.comprado != 1 AND req.urg_id = $id AND cc.id IN $productos ORDER BY cc.id");
        
    }
}
