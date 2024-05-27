<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompraEnvio extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_envio' => 'date:d/m/Y',
        'fecha_entrega_almacen' => 'date:d/m/Y',
        'fecha_entrega_aceptada' => 'date:d/m/Y',
    ];
}
