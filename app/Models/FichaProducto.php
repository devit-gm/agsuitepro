<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaProducto extends Model
{
    use HasFactory;

    protected $table = 'fichas_productos';
    protected $connection = 'site';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'id_ficha',
        'id_producto',
        'cantidad',
        'precio',
    ];

    /**
     * Get the ficha that owns the FichaProducto.
     */
    public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'id_ficha');
    }

    /**
     * Get the producto that owns the FichaProducto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
