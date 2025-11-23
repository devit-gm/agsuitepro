<?php

namespace App\Enums;

enum EstadoMesa: string
{
    case LIBRE = 'libre';
    case OCUPADA = 'ocupada';
    case CERRADA = 'cerrada';
    
    public function color(): string
    {
        return match($this) {
            self::LIBRE => 'success',
            self::OCUPADA => 'warning',
            self::CERRADA => 'secondary'
        };
    }
    
    public function icono(): string
    {
        return match($this) {
            self::LIBRE => 'bi-check-circle-fill',
            self::OCUPADA => 'bi-people-fill',
            self::CERRADA => 'bi-lock-fill'
        };
    }
    
    public function descripcion(): string
    {
        return match($this) {
            self::LIBRE => 'Disponible',
            self::OCUPADA => 'En servicio',
            self::CERRADA => 'Cerrada'
        };
    }
    
    public function badge(): string
    {
        return '<span class="badge bg-' . $this->color() . '"><i class="' . $this->icono() . '"></i> ' . $this->descripcion() . '</span>';
    }
}
