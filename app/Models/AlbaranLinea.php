<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbaranLinea extends Model
{
    use HasFactory;

    protected $connection = 'site';
    protected $table = 'albaran_lineas';

    protected $fillable = [
        'albaran_id',
        'producto_id',
        'cantidad',
        'precio_coste',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio_coste' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relación con el albarán
     */
    public function albaran()
    {
        return $this->belongsTo(Albaran::class);
    }

    /**
     * Relación con el producto (usando UUID como FK)
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'uuid');
    }

    /**
     * Calcular el subtotal automáticamente
     */
    public function calcularSubtotal()
    {
        $this->subtotal = $this->cantidad * $this->precio_coste;
        return $this->subtotal;
    }

    /**
     * Boot method para calcular subtotal automáticamente
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($linea) {
            $linea->subtotal = $linea->cantidad * $linea->precio_coste;
        });

        // Recalcular total del albarán después de guardar/eliminar línea
        static::saved(function ($linea) {
            if ($linea->albaran) {
                $linea->albaran->calcularTotal();
            }
        });

        static::deleted(function ($linea) {
            if ($linea->albaran) {
                $linea->albaran->calcularTotal();
            }
        });
    }
}
