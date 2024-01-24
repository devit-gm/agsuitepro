<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Familia;
use App\Models\Producto;
use Illuminate\Support\Facades\File;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::orderBy('posicion')->get();
        foreach ($productos as $producto) {
            $producto->familia = Familia::find($producto->familia);
        }
        return view('productos.index', compact('productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'imagen' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'posicion' => 'required',
            'familia' => 'required',
            'combinado' => 'required',
            'precio' => 'required'
        ]);
        $imageName = time() . '.' . $request->imagen->extension();
        $request->imagen->move(public_path('images'), $imageName);

        Producto::create([
            'nombre' => $request->nombre,
            'imagen' => $imageName,
            'posicion' => $request->posicion,
            'familia' => $request->familia,
            'combinado' => $request->combinado,
            'precio' => $request->precio
        ]);
        return redirect()->route('productos.index')
            ->with('success', 'Producto creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::find($id);
        return view('productos.show', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'imagen' => 'image|mimes:png,jpg,jpeg|max:2048',
            'posicion' => 'required',
            'familia' => 'required',
            'combinado' => 'required',
            'precio' => 'required'
        ]);
        $producto = Producto::find($id);

        if ($request->imagen != null) {
            if (File::exists(public_path('images') . '/'  . $producto->imagen)) {
                File::delete(public_path('images') . '/'  . $producto->imagen);
            }
            $imageName = time() . '.' . $request->imagen->extension();
            $request->imagen->move(public_path('images'), $imageName);
        } else {
            $imageName = $producto->imagen;
        }

        $producto->update([
            'nombre' => $request->nombre,
            'imagen' => $imageName,
            'posicion' => $request->posicion,
            'familia' => $request->familia,
            'combinado' => $request->combinado,
            'precio' => $request->precio
        ]);
        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Familia::find($id);
        if (File::exists(public_path('images') . '/'  . $producto->imagen)) {
            File::delete(public_path('images') . '/'  . $producto->imagen);
        }
        $producto->delete();
        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado con éxito');
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $familias = Familia::orderBy('posicion')->get();
        return view('productos.create', compact('familias'));
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        $familias = Familia::orderBy('posicion')->get();
        return view('productos.edit', compact('producto'), compact('familias'));
    }
}
