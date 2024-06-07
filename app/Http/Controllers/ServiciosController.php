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
        $servicios = Servicio::orderBy('posicion')->get();
        $num = 1;
        foreach ($servicios as $servicio) {
            $servicio->fichas = FichaServicio::where('id_servicio', $servicio->uuid)->get();
            $servicio->numero = $num;
            //si el usuario activo es administrador
            if (Auth::user()->role_id == 1) {
                $servicio->borrable = true;
                foreach ($servicio->fichas as $servicio) {
                    $ficha = Ficha::find($servicio->id_ficha);
                    if ($ficha->estado == 0) {
                        $servicio->borrable = false;
                        break;
                    }
                }
            } else {
                $servicio->borrable = false;
            }
            $num++;
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
        return redirect()->back()
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
        $servicio->fichas = FichaServicio::where('id_servicio', $servicio->uuid)->get();
        //si el usuario activo es administrador
        if (Auth::user()->role_id == 1) {
            $servicio->borrable = true;
            foreach ($servicio->fichas as $servicio) {
                $ficha = Ficha::find($servicio->id_ficha);
                if ($ficha->estado == 0) {
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
