<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ajustes extends Model
{
    use HasFactory;
    protected $connection = 'site';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'precio_invitado',
        'max_invitados_cobrar',
        'primer_invitado_gratis',
        'activar_invitados_grupo',
        'permitir_comprar_sin_stock',
        'stock_minimo',
        'notificar_stock_bajo',
        'facturar_ficha_automaticamente',
        'permitir_lectura_codigo_barras',
        'limite_inscripcion_dias_eventos',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'modo_operacion',
        'mostrar_usuarios',
        'mostrar_gastos',
        'mostrar_compras'
    ];
}
