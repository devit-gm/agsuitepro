<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaGasto extends Model
{
    use HasFactory;
    protected $connection = 'site';
    protected $table = 'fichas_gastos';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'id_ficha',
        'user_id',
        'descripcion',
        'ticket',
        'precio',
    ];

    /**
     * Get the ficha that owns the FichaGasto.
     */
    public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'id_ficha');
    }

    /**
     * Get the user that owns the FichaGasto.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
