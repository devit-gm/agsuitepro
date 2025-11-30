<?php

namespace App\Enums;

class Role
{
    const ADMIN = 1;
    const MANAGER = 2;
    const CAMARERO = 3;
    const USUARIO_MESAS = 4;
    const COCINERO = 5;

    public static function nombre($roleId)
    {
        return match($roleId) {
            self::ADMIN => 'admin',
            self::MANAGER => 'manager',
            self::CAMARERO => 'camarero',
            self::USUARIO_MESAS => 'usuario_mesas',
            self::COCINERO => 'cocinero',
            default => 'desconocido',
        };
    }
}
