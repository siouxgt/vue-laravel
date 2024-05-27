<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvitacionRestringida extends Model
{
   use HasFactory;

   protected $casts = [
      'fecha_sesion' => 'date:d/m/Y',
   ];

   public static function ultimo(){
      return DB::select("SELECT id FROM invitacion_restringidas ORDER BY id DESC LIMIT 1");
   }

}
