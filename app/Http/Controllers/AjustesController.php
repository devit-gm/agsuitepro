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
        $ajustes = Ajustes::where('id', 1)->first();
        $ajustes->update($request->all());
        return redirect()->route('ajustes.index')->with('success', 'Ajustes actualizados correctamente');
    }
}
