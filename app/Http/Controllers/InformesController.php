<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ficha;
use App\Models\FichaRecibo;
use App\Models\Recibo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class InformesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->method() == 'POST') {
            $site = app('site');
            $request->validate([
                'fecha_inicial' => 'required|date',
                'fecha_final' => 'required|date|after:fecha_inicial',
            ]);

            if (Recibo::where('estado', 0)->count() != 0) {
                $mostrarBotonFacturar = true;
            } else {
                $mostrarBotonFacturar = false;
            }
            if (Auth::user()->rol_id > 3) {
                $usuariosInforme = User::where('site_id', $site->id)->where('id', Auth::id())->get();
            } else {
                $usuariosInforme = User::where('site_id', $site->id)->orderBy('id')->get();
            }

            foreach ($usuariosInforme as $usuarioFicha) {
                if ($request->incluir_facturados == 1) {
                    $usuarioFicha->gastos = Recibo::where('user_id', $usuarioFicha->id)->where('fecha', '>=', $request->fecha_inicial)->where('fecha', '<=', $request->fecha_final)->where('tipo', 1)->sum('precio');
                    $usuarioFicha->compras = Recibo::where('user_id', $usuarioFicha->id)->where('fecha', '>=', $request->fecha_inicial)->where('fecha', '<=', $request->fecha_final)->where('tipo', 2)->sum('precio');;
                } else {
                    $usuarioFicha->gastos = Recibo::where('user_id', $usuarioFicha->id)->where('estado', 0)->where('fecha', '>=', $request->fecha_inicial)->where('fecha', '<=', $request->fecha_final)->where('tipo', 1)->sum('precio');
                    $usuarioFicha->compras = Recibo::where('user_id', $usuarioFicha->id)->where('estado', 0)->where('tipo', 2)->where('fecha', '>=', $request->fecha_inicial)->where('fecha', '<=', $request->fecha_final)->sum('precio');;
                }
                $usuarioFicha->balance = $usuarioFicha->gastos - $usuarioFicha->compras;
            }
        } else {

            $site = app('site');
            if (Recibo::where('estado', 0)->count() != 0) {
                $mostrarBotonFacturar = true;
            } else {
                $mostrarBotonFacturar = false;
            }
            if (Auth::user()->role_id > 3) {
                $usuariosInforme = User::where('site_id', $site->id)->where('id', Auth::id())->get();
            } else {
                $usuariosInforme = User::where('site_id', $site->id)->orderBy('id')->get();
            }

            foreach ($usuariosInforme as $usuarioFicha) {
                $usuarioFicha->gastos = Recibo::where('user_id', $usuarioFicha->id)->where('estado', 0)->where('tipo', 1)->sum('precio');
                $usuarioFicha->compras = Recibo::where('user_id', $usuarioFicha->id)->where('estado', 0)->where('tipo', 2)->sum('precio');;
                $usuarioFicha->balance = $usuarioFicha->gastos - $usuarioFicha->compras;
            }
        }
        return view('informes.index', compact('mostrarBotonFacturar', 'usuariosInforme', 'request'));
    }

    public function facturar(Request $request)
    {
        // Cambiar el estado de los recibos a facturados
        // Todos los recibos que tengan estado 0, se cambian a estado 1
        $recibos = FichaRecibo::where('estado', 0)->get();

        foreach ($recibos as $recibo) {
            $recibo->estado = 1;
            $recibo->save();
        }
        return redirect()->route('informes.index')->with('success', 'Facturación realizada correctamente');
    }
}
