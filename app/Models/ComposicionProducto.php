<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComposicionProducto extends Model
{
    use HasFactory;
    protected $connection = 'site';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'id_producto',
        'id_componente'
    ];

    /**
     * Relación con el producto componente
     */
    public function componenteProducto()
    {
        return $this->belongsTo(Producto::class, 'id_componente', 'uuid');
    }

    /**
     * Relación con el producto padre
     */
    public function productoBase()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'uuid');
    }
}
