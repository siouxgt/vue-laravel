<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoRevisor extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_mesa' => 'date:d/m/Y',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id_creo');
    }
}
