<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $connection = 'site';

    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'name',
        'user_id',
        'start_time',
        'end_time',
        'notificado_recordatorio'
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alias para compatibilidad con notificación
    public function user()
    {
        return $this->usuario();
    }

    
}
