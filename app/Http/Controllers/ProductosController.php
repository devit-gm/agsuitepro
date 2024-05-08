<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Familia;
use App\Models\Producto;
use App\Models\ComposicionProducto;
use Illuminate\Console\View\Components\Component;
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
            $composicion = ComposicionProducto::where('id_producto', $producto->id)->get();
            $producto->familia = Familia::find($producto->familia);
            if ($producto->combinado == 1) {
                $precio = 0.00;
                foreach ($composicion as $componente) {
                    $precio += Producto::find($componente->id_componente)->precio;
                }
                $producto->precio =  number_format((float)$precio, 2, '.', '');
            }
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
        $producto = Producto::find($id);
        if (File::exists(public_path('images') . '/'  . $producto->imagen)) {
            File::delete(public_path('images') . '/'  . $producto->imagen);
        }
        ComposicionProducto::where('id_producto', $id)->delete();
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
        //Find components of product in composition table
        $composicion = ComposicionProducto::where('id_producto', $id)->get();
        if ($producto->combinado == 1) {
            $precio = 0.00;
            foreach ($composicion as $componente) {
                $precio += Producto::find($componente->id_componente)->precio;
            }
            $producto->precio =  number_format((float)$precio, 2, '.', '');
        }
        $familias = Familia::orderBy('posicion')->get();
        return view('productos.edit', compact('producto'), compact('familias'));
    }

    public function components($id)
    {
        $producto = Producto::find($id);
        //Find components of product in composition table
        $composicion = ComposicionProducto::where('id_producto', $id)->get();
        if ($producto->combinado == 1) {
            $precio = 0.00;
            foreach ($composicion as $componente) {
                $precio += Producto::find($componente->id_componente)->precio;
            }
            $producto->precio =  number_format((float)$precio, 2, '.', '');
        }
        $familias = Familia::orderBy('posicion')->get();
        $producto->familia = Familia::find($producto->familia);

        $componentes = Producto::where('combinado', 0)->orderBy('posicion')->get();
        foreach ($componentes as $componente) {
            $esComposicion = ComposicionProducto::where('id_producto', $id)->where('id_componente', $componente->id)->get();

            if ($esComposicion->count() > 0) {
                $componente->familia = 1;
            } else {
                $componente->familia = 0;
            }
        }
        return view('productos.components', compact('producto', 'familias', 'componentes'));
    }

    public function update_components(Request $request, string $id)
    {
        ComposicionProducto::where('id_producto', $id)->delete();
        foreach ($request->componentes as $componente) {
            ComposicionProducto::create([
                'id_producto' => $id,
                'id_componente' => $componente
            ]);
        }

        $producto = Producto::find($id);
        //Find components of product in composition table
        $composicion = ComposicionProducto::where('id_producto', $id)->get();
        if ($producto->combinado == 1) {
            $precio = 0.00;
            foreach ($composicion as $componente) {
                $precio += Producto::find($componente->id_componente)->precio;
            }
            $producto->precio =  number_format((float)$precio, 2, '.', '');
        }
        $familias = Familia::orderBy('posicion')->get();
        $producto->familia = Familia::find($producto->familia);

        $componentes = Producto::where('combinado', 0)->orderBy('posicion')->get();
        foreach ($componentes as $componente) {
            $esComposicion = ComposicionProducto::where('id_producto', $id)->where('id_componente', $componente->id)->get();

            if ($esComposicion->count() > 0) {
                $componente->familia = 1;
            } else {
                $componente->familia = 0;
            }
        }
        return view('productos.components', compact('producto', 'familias', 'componentes'));
    }
}
