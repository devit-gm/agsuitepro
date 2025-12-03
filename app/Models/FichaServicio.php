<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaServicio extends Model
{
    use HasFactory;
    protected $connection = 'site';
    protected $table = 'fichas_servicios';

    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'id_ficha',
        'id_servicio',
        'precio',
    ];

    /**
     * Get the ficha that owns the FichaServicio.
     */
    public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'id_ficha');
    }

    /**
     * Get the servicio that owns the FichaServicio.
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'uuid');
    }
}
