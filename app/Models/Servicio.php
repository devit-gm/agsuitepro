<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $connection = 'site';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'nombre',
        'posicion',
        'precio',
        'iva'
    ];

    /**
     * Relación con FichaServicio
     */
    public function fichasRelacion()
    {
        return $this->hasMany(FichaServicio::class, 'id_servicio', 'uuid');
    }

    /**
     * Relación con fichas a través de FichaServicio
     */
    public function fichas()
    {
        return $this->belongsToMany(Ficha::class, 'ficha_servicios', 'id_servicio', 'id_ficha', 'uuid', 'uuid');
    }

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
}
