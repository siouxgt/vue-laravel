<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompraFactura extends Model
{
    use HasFactory;

     protected $casts = [
        'fecha_prefactura_envio' => 'date:d/m/Y',
        'fecha_prefactura_aceptada' => 'date:d/m/Y',
        'fecha_factura_envio' => 'date:d/m/Y',
        'fecha_factura_aceptada' => 'date:d/m/Y',
        'fecha_sap' => 'date:d/m/Y',
    ];
}
