<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid; // Add this line

class Ficha extends Model
{
    use HasFactory;
    protected $connection = 'site';
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'user_id',
        'tipo',
        'estado',
        'descripcion',
        'invitados_grupo',
        'fecha',
        'precio',
        'hora',
        'menu',
        'responsables'
    ];

    /**
     * Get the user that owns the Ficha.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the productos for the ficha.
     */
    public function productos()
    {
        return $this->hasMany(FichaProducto::class, 'id_ficha', 'uuid');
    }

    /**
     * Get the servicios for the ficha.
     */
    public function servicios()
    {
        return $this->hasMany(FichaServicio::class, 'id_ficha', 'uuid');
    }

    /**
     * Get the gastos for the ficha.
     */
    public function gastos()
    {
        return $this->hasMany(FichaGasto::class, 'id_ficha', 'uuid');
    }

    /**
     * Get the usuarios relacionados with the ficha.
     */
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'ficha_usuario', 'ficha_uuid', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
}
