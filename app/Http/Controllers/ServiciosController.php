<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\FichaServicio;
use Illuminate\Http\Request;
use App\Models\Servicio;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = servicios_menu()->load(['fichasRelacion.ficha']);
        $num = 1;
        foreach ($servicios as $servicio) {
            $servicio->numero = $num++;
            // Si el usuario activo es administrador
            if (Auth::check() && Auth::user()->role_id == 1 && isset($servicio->fichasRelacion)) {
                $servicio->borrable = true;
                foreach ($servicio->fichasRelacion as $fichaServicio) {
                    if (isset($fichaServicio->ficha) && $fichaServicio->ficha && $fichaServicio->ficha->estado == 0) {
                        $servicio->borrable = false;
                        break;
                    }
                }
            } else {
                $servicio->borrable = false;
            }
        }
        return view('servicios.index', compact('servicios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'posicion' => 'required',
            'precio' => 'required'
        ]);


        Servicio::create([
            'uuid' => (string) Uuid::uuid4(),
            'nombre' => $request->nombre,
            'posicion' => $request->posicion,
            'precio' => $request->precio
        ]);
        \Cache::forget('servicios_menu');
        return redirect()->route('servicios.index')
            ->with('success', __('Servicio creado con éxito.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $servicio = Servicio::find($id);
        return view('servicios.show', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'posicion' => 'required',
            'precio' => 'required'
        ]);
        $servicio = Servicio::find($id);

        $servicio->update([
            'nombre' => $request->nombre,
            'posicion' => $request->posicion,
            'precio' => $request->precio
        ]);
        \Cache::forget('servicios_menu');
        return redirect()->back()
            ->with('success', __('Servicio actualizado con éxito.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicio = Servicio::find($id);
        $servicio->delete();
        \Cache::forget('servicios_menu');
        return redirect()->route('servicios.index')
            ->with('success', __('Servicio eliminado con éxito'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $servicios = Servicio::orderBy('posicion')->get();
        return view('servicios.create', compact('servicios'));
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $servicio = Servicio::with(['fichasRelacion.ficha'])->findOrFail($id);
        $servicio->fichas = $servicio->fichasRelacion;
        //si el usuario activo es administrador
        if (Auth::check() && Auth::user()->role_id == 1) {
            $servicio->borrable = true;
            foreach ($servicio->fichas as $fichaServicio) {
                if ($fichaServicio->ficha && $fichaServicio->ficha->estado == 0) {
                    $servicio->borrable = false;
                    break;
                }
            }
        } else {
            $servicio->borrable = false;
        }
        return view('servicios.edit', compact('servicio'));
    }
}
