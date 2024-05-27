<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rfc',
        'curp',
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'estatus',
        'rol',
        'cargo',
        'email',
        'genero',
        'password',
        'urg_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol(){
        return $this->belongsTo(Rol::class);
    }

    public function urg(){
        return $this->belongsTo(Urg::class);
    }

    public function contrato(){
        return $this->hasMany(ContratoMarco::class);
    }

    public function ordenCompra(){
        return $this->hasMany(OrdenCompra::class);
    }

    public static function userResponsables($urg_id){
        return DB::select('SELECT u.id, u.nombre, u.primer_apellido, u.segundo_apellido, u.cargo, r.rol FROM users AS u JOIN rols AS r ON u.rol_id = r.id WHERE u.urg_id = '. $urg_id.' AND u.rol_id <> 6');
    }

    public static function userResponsablesTecnico($urg_id){
        return DB::select('SELECT u.id, u.nombre, u.primer_apellido, u.segundo_apellido, u.cargo, r.rol FROM users AS u JOIN rols AS r ON u.rol_id = r.id WHERE u.urg_id = '. $urg_id .' AND u.rol_id = 6');
    }

    public static function allUsuarios(){

        return DB::select("SELECT u.id, CONCAT(u.nombre, ' ', u.primer_apellido, ' ',u.segundo_apellido) AS nombre, u.rfc, ur.nombre AS urg, r.rol FROM users AS u JOIN urgs AS ur ON u.urg_id = ur.id JOIN rols AS r ON u.rol_id = r.id");
    }

    public static function usuarioRfc($rfc){
        return DB::select("SELECT u.rfc, u.nombre, u.primer_apellido, u.segundo_apellido, u.cargo, u.email, u.telefono, u.extension FROM users AS u WHERE u.rfc = '".$rfc."' AND u.estatus = true");
    }

    public static function nombre(){
        return DB::select("SELECT u.id, CONCAT(u.nombre, ' ', u.primer_apellido, ' ',u.segundo_apellido) AS nombre FROM users AS u");
    }

}
