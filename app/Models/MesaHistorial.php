<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MesaHistorial extends Model
{
    protected $connection = 'site';
    protected $table = 'mesa_historial';
    
    public $timestamps = false;
    
    protected $fillable = [
        'mesa_id',
        'accion',
        'camarero_id',
        'camarero_anterior_id',
        'detalles',
        'fecha_accion'
    ];
    
    protected $casts = [
        'detalles' => 'array',
        'fecha_accion' => 'datetime'
    ];
    
    // Relaciones
    public function mesa()
    {
        return $this->belongsTo(Ficha::class, 'mesa_id', 'uuid');
    }
    
    public function camarero()
    {
        return $this->belongsTo(User::class, 'camarero_id');
    }
    
    public function camareroAnterior()
    {
        return $this->belongsTo(User::class, 'camarero_anterior_id');
    }
}
