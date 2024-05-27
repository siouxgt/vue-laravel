<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompraSustitucion extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_envio' => 'date:d/m/Y',
        'fecha_entrega' => 'date:d/m/Y',
        'fecha_aceptada' => 'date:d/m/Y',
        'created_at' => 'date:d/m/Y',
    ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function ordenCompra(){
        return $this->belongsTo(OrdenCompra::class);
    }

    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id');
    }

    public function urg(){
        return $this->belongsTo(Urg::class);
    }
}
