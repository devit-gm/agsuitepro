<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ajustes extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'precio_invitado',
        'max_invitados_cobrar',
        'primer_invitado_gratis',
        'activar_invitados_grupo',
        'permitir_comprar_sin_stock'
    ];
}
