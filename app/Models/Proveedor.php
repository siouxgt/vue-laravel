<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Proveedor extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $guard =  'proveedor';

    protected $table = "proveedores";

    protected $fillable = [
        'rfc',
        'password'
    ];
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'fecha_constitucion_identidad' => 'date:d/m/Y',
        'fecha_reg_identidad' => 'date:d/m/Y',
        'fecha_reg_representante' => 'date:d/m/Y',
    ];

    public function producto(){
        return $this->hasMany(ProveedorFichaProducto::class);
    }

    public function ordenBien(){
        return $this->hasMany(OrdenCompraBien::class);
    }

    public function ordenEstatus(){
        return $this->hasMany(OrdenCompraEstatus::class);
    }

    public function contratoProveedor(){
        return $this->hasMany(Contrato::class);
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function prorroga(){
        return $this->hasMany(OrdenCompraProrroga::class);
    }

    public static function allProveedor()
    {
        return  DB::select("SELECT id, nombre, folio_padron, rfc, CASE WHEN estatus = true THEN 'Activo' ELSE 'Inactivo' END AS estatus FROM proveedores");
    }

    public static function rfcProveedor()
    {
        return DB::select("SELECT id, rfc, nombre FROM proveedores WHERE estatus = true");
    }

    public static function ultimosProveedores(){
        return DB::select('SELECT p.id, p.nombre, (SELECT COUNT(pfp.id) FROM proveedores_fichas_productos AS pfp WHERE pfp.proveedor_id = p.id AND pfp.publicado = true) AS productos FROM proveedores AS p WHERE p.estatus = true AND p.perfil_completo = true ORDER BY p.id DESC LIMIT 5');
    }

    public static function razon(){
        return DB::select("SELECT p.id, p.nombre FROM proveedores AS p");
    }
}
