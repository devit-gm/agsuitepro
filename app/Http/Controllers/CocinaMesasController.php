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
        // Obtener fichas abiertas (estado 0) con productos no preparados
        $fichas = Ficha::with(['productos.producto'])
            ->where('estado', 0)
            ->where('modo', 'mesa')
            ->where('estado_mesa','ocupada')
            ->orderBy('hora_apertura', 'asc')
            ->get();

        // Filtrar fichas con productos pendientes
        $fichas = $fichas->filter(function($ficha) {
            return $ficha->productos->where('estado', '=', 'pendiente')->count() > 0;
        });

        return view('cocina.mesas', compact('fichas'));
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
