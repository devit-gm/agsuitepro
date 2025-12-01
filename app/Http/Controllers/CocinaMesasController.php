<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ficha;
use App\Models\FichaProducto;

class CocinaMesasController extends Controller
{
    // Vista de cocina para mesas
    public function index()
    {
        $fichas = $this->getFichasCocina();
        return view('cocina.mesas', compact('fichas'));
    }

    // Método para obtener datos de cocina (reutilizable)
    private function getFichasCocina()
    {
        // Obtener fichas abiertas (estado 0) con productos no preparados
        $fichas = Ficha::with([
            'productos.producto.familiaObj',
            'primerProducto',
            'historial' => function($q) {
                $q->where('accion', 'abrir')->orderByDesc('fecha_accion');
            }
        ])
        ->where('estado', 0)
        ->where('modo', 'mesa')
        ->where('estado_mesa','ocupada')
        ->get();
        
        // Ordenar por fecha del primer producto pendiente (más antiguo primero)
        $fichas = $fichas->sortBy(function($ficha) {
            $primerProductoPendiente = $ficha->productos
                ->where('estado', 'pendiente')
                ->sortBy('created_at')
                ->first();
            return $primerProductoPendiente ? $primerProductoPendiente->created_at : now();
        });

        // Filtrar productos de familias que deben mostrarse en cocina
        $fichas = $fichas->map(function($ficha) {
            $ficha->productos = $ficha->productos->filter(function($producto) {
                return $producto->estado === 'pendiente' &&
                    $producto->producto &&
                    $producto->producto->familiaObj &&
                    optional($producto->producto->familiaObj)->mostrar_en_cocina == 1;
            });
            return $ficha;
        });

        // Filtrar fichas que tengan productos pendientes de familias visibles en cocina
        $fichas = $fichas->filter(function($ficha) {
            return $ficha->productos->count() > 0;
        });

        // Añadir la última apertura de la mesa a cada ficha
        $fichas->transform(function($ficha) {
            $ficha->ultima_apertura = optional($ficha->historial->first())->fecha_accion;
            return $ficha;
        });

        // Convertir a valores para mantener el orden
        return $fichas->values();
    }

    // Endpoint AJAX para actualizar datos
    public function actualizar()
    {
        $fichas = $this->getFichasCocina();
        return view('cocina.mesas-content', compact('fichas'));
    }

    // Marcar producto como preparado (POST JSON)
    public function preparar(Request $request)
    {
        $request->validate([
            'ficha_producto' => 'required'
        ]);

        $producto = FichaProducto::where('uuid', $request->ficha_producto)
            ->first();
        if (!$producto) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
        }
        $producto->estado = 'preparado';
        $producto->save();
        return response()->json(['success' => true]);
    }
}
