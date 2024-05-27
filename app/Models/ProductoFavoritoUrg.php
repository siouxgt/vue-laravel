<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductoFavoritoUrg extends Model
{
    use HasFactory;
    protected $table = "productos_favoritos_urg";

    public static function rfcProveedor(){
        return DB::select("SELECT id, rfc, nombre FROM proveedores WHERE estatus = true");
    }

    public static function totalFavoritosUrg($idUrg){
        $sql = "SELECT COUNT(*) AS total FROM productos_favoritos_urg WHERE urg_id = $idUrg AND deleted_at IS NULL";
        return DB::select($sql);
    }

    public static function totalFavoritosPorProveedor($proveedorId){
        return DB::select("SELECT count(pfu.id) total FROM productos_favoritos_urg pfu JOIN proveedores_fichas_productos AS pfp ON pfu.proveedor_ficha_producto_id = pfp.id WHERE pfp.proveedor_id = $proveedorId");
    }
}
