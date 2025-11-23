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
        'ean13',
        'iva'
    ];

    /*
     |--------------------------------------------------------------------------
     | MÉTODOS DE CÁLCULO
     |--------------------------------------------------------------------------
     */

    /**
     * Calcular precio con IVA incluido (el precio ya viene con IVA)
     */
    public function precioConIva()
    {
        return $this->precio; // El precio ya incluye IVA
    }

    /**
     * Calcular solo el importe del IVA
     */
    public function importeIva($cantidad = 1)
    {
        $iva = $this->iva ?? 0;
        $pvp = $this->precio * $cantidad;
        $baseImponible = $pvp / (1 + $iva / 100);
        return $pvp - $baseImponible;
    }

    /**
     * Obtener base imponible (precio sin IVA)
     */
    public function baseImponible($cantidad = 1)
    {
        $iva = $this->iva ?? 0;
        $pvp = $this->precio * $cantidad;
        return $pvp / (1 + $iva / 100);
    }

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
