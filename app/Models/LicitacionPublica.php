<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicitacionPublica extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_convocatoria' => 'date:d/m/Y',
        'fecha_aclaracion' => 'date:d/m/Y',
        'fecha_propuesta' => 'date:d/m/Y',
        'fecha_fallo' => 'date:d/m/Y',
   ];
}
