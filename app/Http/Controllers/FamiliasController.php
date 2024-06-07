<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Familia;
use App\Models\Producto;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Auth;

class FamiliasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familias = Familia::orderBy('posicion')->get();
        foreach ($familias as $familia) {
            //si la familia tiene productos no se puede borrar
            //si el usuario activo es administrador
            if (Auth::user()->role_id == 1) {
                if (Producto::where('familia', $familia->uuid)->first()) {
                    $familia->borrable = false;
                } else {
                    $familia->borrable = true;
                }
            } else {
                $familia->borrable = false;
            }
        }
        return view('familias.index', compact('familias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'imagen' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'posicion' => 'required'
        ]);
        $imageName = time() . '.' . $request->imagen->extension();
        $request->imagen->move(public_path('images'), $imageName);

        // ...

        Familia::create([
            'uuid' => (string) Uuid::uuid4(),
            'nombre' => $request->nombre,
            'imagen' => $imageName,
            'posicion' => $request->posicion
        ]);
        return redirect()->route('familias.index')
            ->with('success', 'Familia creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $familia = Familia::find($id);
        return view('familias.show', compact('familia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'imagen' => 'image|mimes:png,jpg,jpeg|max:2048',
            'posicion' => 'required'
        ]);
        $familia = Familia::find($id);

        if ($request->imagen != null) {
            if (File::exists(public_path('images') . '/'  . $familia->imagen)) {
                File::delete(public_path('images') . '/'  . $familia->imagen);
            }
            $imageName = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $imageName);
        } else {
            $imageName = $familia->imagen;
        }

        $familia->update([
            'nombre' => $request->nombre,
            'imagen' => $imageName,
            'posicion' => $request->posicion
        ]);
        return redirect()->route('familias.index')
            ->with('success', 'Familia actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $familia = Familia::find($id);
        if (File::exists(public_path('images') . '/'  . $familia->imagen)) {
            File::delete(public_path('images') . '/'  . $familia->imagen);
        }
        $familia->delete();
        return redirect()->route('familias.index')
            ->with('success', 'Familia eliminada con éxito');
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('familias.create');
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $id
     */
    public function edit($uuid)
    {
        $familia = Familia::where('uuid', $uuid)->get();
        foreach ($familia as $familia) {
            if (Producto::where('familia', $uuid)->first()) {
                $familia->borrable = false;
            } else {
                $familia->borrable = true;
            }
        }
        return view('familias.edit', compact('familia'));
    }

    public function view($id)
    {
        $familia = Familia::find($id);
        $productos = Producto::where('familia', $id)->get();
        return view('familias.view', compact('productos', 'familia'));
    }
}
