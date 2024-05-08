<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::orderBy('posicion')->get();
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
            'nombre' => $request->nombre,
            'posicion' => $request->posicion,
            'precio' => $request->precio
        ]);
        return redirect()->route('servicios.index')
            ->with('success', 'Servicio creado con éxito.');
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
        return redirect()->route('servicios.index')
            ->with('success', 'Servicio actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicio = Servicio::find($id);
        $servicio->delete();
        return redirect()->route('servicio.index')
            ->with('success', 'Servicio eliminado con éxito');
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
        $servicio = Servicio::find($id);
        return view('servicios.edit', compact('servicio'));
    }
}
