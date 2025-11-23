<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ajustes;

class AjustesController extends Controller
{
    public function index()
    {
        $ajustes = Ajustes::where('id', 1)->first();
        return view('ajustes.index', compact('ajustes'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'precio_invitado' => 'nullable|numeric|min:0',
            'max_invitados_cobrar' => 'nullable|integer|min:0',
            'primer_invitado_gratis' => 'nullable|boolean',
            'activar_invitados_grupo' => 'nullable|boolean',
            'permitir_comprar_sin_stock' => 'nullable|boolean',
            'stock_minimo' => 'nullable|integer|min:0',
            'notificar_stock_bajo' => 'nullable|boolean',
            'facturar_ficha_automaticamente' => 'nullable|boolean',
            'permitir_lectura_codigo_barras' => 'nullable|boolean',
            'limite_inscripcion_dias_eventos' => 'nullable|integer|min:0',
            'modo_operacion' => 'nullable|in:fichas,mesas',
            'mostrar_usuarios' => 'nullable|boolean',
            'mostrar_gastos' => 'nullable|boolean',
            'mostrar_compras' => 'nullable|boolean',
        ]);

        $ajustes = Ajustes::where('id', 1)->first();
        $ajustes->update($request->all());
        return redirect()->route('ajustes.index')->with('success', __('Ajustes actualizados correctamente'));
    }
}
