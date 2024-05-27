<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompraProrroga extends Model
{
    use HasFactory;

     protected $casts = [
        'fecha_solicitud' => 'date:d/m/Y',
        'fecha_entrega_compromiso' => 'date:d/m/Y',
        'fecha_aceptacion' => 'date:d/m/Y',
        'created_at' => 'date:d/m/Y',
    ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }
}
