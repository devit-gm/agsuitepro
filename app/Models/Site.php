<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $table = 'sitios';
    protected $connection = 'central';
    protected $fillable = [
        'nombre', 'dominio', 'ruta_logo', 'ruta_logo_nav', 'ruta_estilos', 'db_host', 'db_name', 'db_user', 'db_password', 'central', 'favicon',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'locale',
        'direccion',
        'cif',
        'telefono',
        'carpeta_pwa'
    ];

    protected $hidden = [
        'mail_password',
    ];
}
