<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaMesa extends Model
{
    use HasFactory;
    
    protected $connection = 'site';
    protected $table = 'facturas_mesas';
    public $timestamps = false;
    
    protected $fillable = [
        'numero_factura',
        'fecha',
        'mesa_id',
        'camarero_id',
        'cliente_nombre',
        'cliente_nif',
        'subtotal',
        'total_iva',
        'total',
        'detalles'
    ];
    
    protected $casts = [
        'detalles' => 'array',
        'fecha' => 'date',
        'subtotal' => 'decimal:2',
        'total_iva' => 'decimal:2',
        'total' => 'decimal:2'
    ];
    
    /*
     |--------------------------------------------------------------------------
     | RELACIONES
     |--------------------------------------------------------------------------
     */
    
    /**
     * Mesa asociada a la factura
     */
    public function mesa()
    {
        return $this->belongsTo(Ficha::class, 'mesa_id', 'uuid');
    }
    
    /**
     * Camarero que generó la factura
     */
    public function camarero()
    {
        return $this->belongsTo(User::class, 'camarero_id');
    }
    
    /*
     |--------------------------------------------------------------------------
     | MÉTODOS AUXILIARES
     |--------------------------------------------------------------------------
     */
    
    /**
     * Generar el siguiente número de factura para el año actual
     */
    public static function generarNumeroFactura()
    {
        $año = date('Y');
        $ultimaFactura = self::whereYear('fecha', $año)
            ->orderBy('numero_factura', 'desc')
            ->first();
        
        if ($ultimaFactura) {
            // Extraer el número de la última factura (formato: 2025/001)
            $partes = explode('/', $ultimaFactura->numero_factura);
            $numero = isset($partes[1]) ? intval($partes[1]) : 0;
            $siguiente = $numero + 1;
        } else {
            $siguiente = 1;
        }
        
        return $año . '/' . str_pad($siguiente, 3, '0', STR_PAD_LEFT);
    }
    
    /**
     * Obtener desglose de IVA agrupado
     */
    public function getDesgloseIva()
    {
        $detalles = $this->detalles;
        $desglose = [];
        
        if (isset($detalles['lineas']) && is_array($detalles['lineas'])) {
            foreach ($detalles['lineas'] as $linea) {
                $ivaKey = number_format($linea['iva'] ?? 0, 2);
                
                if (!isset($desglose[$ivaKey])) {
                    $desglose[$ivaKey] = [
                        'porcentaje' => $linea['iva'] ?? 0,
                        'base' => 0,
                        'cuota' => 0
                    ];
                }
                
                $desglose[$ivaKey]['base'] += $linea['base_imponible'] ?? 0;
                $desglose[$ivaKey]['cuota'] += $linea['importe_iva'] ?? 0;
            }
        }
        
        return $desglose;
    }
}
