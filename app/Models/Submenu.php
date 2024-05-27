<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_inicio_alta' => 'date:d/m/Y',
        'fecha_fin_alta' => 'date:d/m/Y',
        'fecha_inicio_expediente' => 'date:d/m/Y',
        'fecha_fin_expediente' => 'date:d/m/Y',
        'fecha_inicio_revisor' => 'date:d/m/Y',
        'fecha_fin_revisor' => 'date:d/m/Y',
        'fecha_inicio_proveedor' => 'date:d/m/Y',
        'fecha_fin_proveedor' => 'date:d/m/Y',
        'fecha_inicio_producto' => 'date:d/m/Y',
        'fecha_fin_producto' => 'date:d/m/Y',
        'fecha_inicio_urg' => 'date:d/m/Y',
        'fecha_fin_urg' => 'date:d/m/Y',
   ];
}
