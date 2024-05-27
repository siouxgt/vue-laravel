<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Urg extends Model
{
    use HasFactory;
    protected $table = "urgs";
    protected $fillable = [
        'ccg',
        'tipo',
        'nombre',
        'direccion',
        'responsable',
        'fecha_adhesion',
        'archivo',
        'estatus'
    ];

    public function validaciones(){
        return $this->hasMany(ValidacionesTecnicas::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function requisiciones(){
        return $this->hasMany(Requisicione::class);
    }

    public function ordenCompra(){
        return $this->hasMany(OrdenCompra::class);
    }

    public function contratoMarco(){
        return $this->hasMany(ContratoMarco::class);
    }

    public function contratoUrg(){
        return $this->hasMany(Contrato::class);
    }

    public static function allURG()
    {
        $urgs = DB::select("SELECT id, ccg, nombre, CASE WHEN estatus = true THEN 'Activo' ELSE 'Inactivo' END AS estatus, to_char(fecha_adhesion , 'DD-MM-YYYY') as fecha_adhesion FROM urgs");
        return $urgs;
    }

    public static function cargarURGs($id = 0) //Función que permite cargar todos los datos de una URG teniendo en cuenta si esta activo o no
    {
        $sql = "SELECT * FROM urgs WHERE estatus = true";
        if ($id != 0) {
            $sql .= " AND id = $id";
        }
        return DB::select($sql);
    }

    //Relación muchos a muchos
    public function contratosMarcos()
    {
        return $this->belongsToMany('App\Models\ContratoMarco');
    }
}
