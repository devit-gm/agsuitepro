<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class VerificarRolesService
{
    public function verificar($usuario, $rol)
    {
        return $usuario->hasRole($rol);
    }
}
