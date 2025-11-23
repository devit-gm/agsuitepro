<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $connection = 'site';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'nombre',
        'imagen',
        'posicion',
        'familia',
        'combinado',
        'precio',
        'ean13'
    ];

    /*
     |--------------------------------------------------------------------------
     | RELACIONES
     |--------------------------------------------------------------------------
     */

    // 🔹 Un producto pertenece a una familia
    public function familiaObj()
    {
        return $this->belongsTo(Familia::class, 'familia', 'uuid');
    }

    // 🔹 Todas las líneas de composición donde este producto es el principal
    public function composicion()
    {
        return $this->hasMany(ComposicionProducto::class, 'id_producto', 'uuid');
    }

    // 🔹 Productos componentes (productos hijos del combinado)
    public function componentes()
    {
        return $this->belongsToMany(
            Producto::class,
            'composicion_productos',
            'id_producto',      // FK hacia este producto
            'id_componente',    // FK hacia el componente
            'uuid',             // PK de este producto
            'uuid'              // PK del componente
        );
    }

    // 🔹 Las fichas donde aparece este producto
    public function fichas()
    {
        return $this->hasMany(FichaProducto::class, 'id_producto', 'uuid');
    }
}
