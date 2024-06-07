<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\FichaGasto;
use App\Models\FichaUsuario;
use Illuminate\Http\Request;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\FichaServicio;
use App\Models\FichaProducto;
use Illuminate\Support\Facades\File;
use App\Models\Familia;
use App\Models\Producto;
use Ramsey\Uuid\Type\Decimal;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class FichasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Carbon::setLocale('es');
        $fichas = Ficha::whereDate('fecha', '>=', Carbon::now()->toDateString())
            ->orwhere('estado', 0)
            ->orderBy('fecha')
            ->get();
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        foreach ($fichas as $ficha) {

            $fecha = Carbon::parse($ficha->fecha);
            $mes = substr($meses[intval($fecha->format('m')) - 1], 0, 3);
            $ficha->usuario = User::find($ficha->user_id);
            $ficha->precio = $this->ObtenerImporteFicha($ficha);
            $ficha->uuid = $ficha->uuid;
            $ficha->mes = $mes;
            //Si el usuario de la ficha es el usuario activo
            //O si el usuario activo es administrador
            //O si el usuario está en el grupo de la ficha
            //La ficha se puede borrar
            if ($ficha->user_id == Auth::id() || Auth::user()->role_id == 1 || FichaUsuario::where('id_ficha', $ficha->uuid)->where('id_usuario', Auth::id())->first()) {
                $ficha->borrable = true;
            } else {
                $ficha->borrable = false;
            }
        }

        return view('fichas.index', compact('fichas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'max:255',
            'fecha' => 'required|date',
            'tipo' => 'required'
        ]);

        $descripcion = '';
        if ($request->descripcion == null) {
            $descripcion = '';
        } else {
            $descripcion = $request->descripcion;
        }

        // ...

        Ficha::create([
            'uuid' => (string) Uuid::uuid4(),
            'descripcion' => $descripcion,
            'user_id' => $request->user_id,
            'precio' => $request->precio,
            'invitados_grupo' => $request->invitados_grupo,
            'estado' => $request->estado,
            'tipo' => $request->tipo,
            'fecha' => $request->fecha
        ]);
        return redirect()->route('fichas.index')
            ->with('success', 'Ficha creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $ficha = Ficha::find($uuid);
        if ($ficha->user_id == Auth::id() || Auth::user()->role_id == 1 || FichaUsuario::where('id_ficha', $ficha->uuid)->where('id_usuario', Auth::id())->first()) {
            $ficha->borrable = true;
        } else {
            $ficha->borrable = false;
        }
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $fechaCambiada = Carbon::parse($ficha->fecha)->todateString();
        return view('fichas.edit', compact('ficha', 'fechaCambiada'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $request->validate([
            'descripcion' => 'max:255',
            'fecha' => 'required|date',
            'tipo' => 'required'
        ]);
        $ficha = Ficha::find($uuid);

        if ($request->descripcion == null) {
            $ficha->descripcion = '';
        } else {
            $ficha->descripcion = $request->descripcion;
        }
        $descripcion = $ficha->descripcion;

        $ficha->update([
            'descripcion' => $descripcion,
            'user_id' => $request->user_id,
            'precio' =>  $this->ObtenerImporteFicha($ficha),
            'invitados_grupo' => $request->invitados_grupo,
            'estado' => $request->estado,
            'tipo' => $request->tipo,
            'fecha' => $request->fecha
        ]);
        return redirect()->route('fichas.index')
            ->with('success', 'Ficha actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $fichaProductos = FichaProducto::where('id_ficha', $uuid)->get();
        foreach ($fichaProductos as $fichaProducto) {
            $fichaProducto->delete();
        }
        $fichaServicios = FichaServicio::where('id_ficha', $uuid)->get();
        foreach ($fichaServicios as $fichaServicio) {
            $fichaServicio->delete();
        }
        $fichaUsuarios = FichaUsuario::where('id_ficha', $uuid)->get();
        foreach ($fichaUsuarios as $fichaUsuario) {
            $fichaUsuario->delete();
        }
        $fichaGastos = FichaGasto::where('id_ficha', $uuid)->get();
        foreach ($fichaGastos as $fichaGasto) {
            if (File::exists(public_path('images') . '/'  . $fichaGasto->ticket)) {
                File::delete(public_path('images') . '/'  . $fichaGasto->ticket);
            }
            $fichaGasto->delete();
        }
        $ficha = Ficha::find($uuid);
        $ficha->delete();
        return redirect()->route('fichas.index')
            ->with('success', 'Ficha eliminada con éxito');
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $userId = Auth::id();
        $userTimezone = 'Europe/Madrid';
        $currentDateTime = Carbon::now($userTimezone);
        return view('fichas.create', compact('userId', 'currentDateTime'));
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $uuid
     */
    public function edit(string $uuid)
    {
        $ficha = Ficha::where('uuid', $uuid)->get()->first();
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $fechaCambiada = Carbon::parse($ficha->fecha)->todateString();
        if ($ficha->user_id == Auth::id() || Auth::user()->role_id == 1 || FichaUsuario::where('id_ficha', $ficha->uuid)->where('id_usuario', Auth::id())->first()) {
            $ficha->borrable = true;
        } else {
            $ficha->borrable = false;
        }
        return view('fichas.edit', compact('ficha', 'fechaCambiada'));
    }

    private function ObtenerImporteFicha($ficha)
    {
        $precio = 0.0;
        $productos = FichaProducto::where('id_ficha', $ficha->uuid)->get();
        foreach ($productos as $producto) {
            $precio += $producto->precio;
        }
        $usuarios = FichaUsuario::where('id_ficha', $ficha->uuid)->get();
        foreach ($usuarios as $usuario) {
            $precio += $usuario->invitados;
        }
        $servicios = FichaServicio::where('id_ficha', $ficha->uuid)->get();
        foreach ($servicios as $servicio) {
            $precio += $servicio->precio;
        }
        $compras = FichaGasto::where('id_ficha', $ficha->uuid)->get();
        foreach ($compras as $compra) {
            $precio += $compra->precio;
        }
        if ($ficha->invitados_grupo > 0) {
            $precio = $precio + $ficha->invitados_grupo;
        }
        return $precio;
    }

    public function familias(string $uuid)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $familias = Familia::orderBy('posicion')->get();
        return view('fichas.familias', compact('ficha', 'familias'));
    }

    public function productos($uuid, $uuid2)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $familia = Familia::find($uuid2);
        $productos = Producto::where('familia', $uuid2)->orderBy('posicion')->get();
        return view('fichas.productos', compact('ficha', 'familia', 'productos'));
    }

    public function usuarios($uuid)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $usuariosFicha = User::orderBy('id')->get();
        foreach ($usuariosFicha as $usuarioFicha) {
            //si el user_id está en FichaUsuario de la ficha lo ponemos como marcado
            $fichaUsuario = FichaUsuario::where('id_ficha', $ficha->uuid)->where('user_id', $usuarioFicha->id)->first();
            if ($fichaUsuario) {
                $usuarioFicha->marcado = true;
                $usuarioFicha->invitados = $fichaUsuario->invitados;
            } else {
                $usuarioFicha->marcado = false;
                $usuarioFicha->invitados = 0;
            }
        }
        return view('fichas.usuarios', compact('ficha', 'usuariosFicha'));
    }

    public function updateusuarios($uuid, Request $request)
    {
        FichaUsuario::where('id_ficha', $uuid)->delete();
        if ($request->usuarios != null) {
            foreach ($request->usuarios as $usuario) {
                $idUsuario = intval(str_replace("]", "", str_replace("[", "", $usuario)));
                FichaUsuario::create([
                    'uuid' => (string) Uuid::uuid4(),
                    'id_ficha' => $uuid,
                    'user_id' => $idUsuario,
                    'invitados' => $request->invitados[$idUsuario] ?? 0
                ]);
            }
        }
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $usuariosFicha = User::orderBy('id')->get();
        foreach ($usuariosFicha as $usuarioFicha) {
            //si el user_id está en FichaUsuario de la ficha lo ponemos como marcado
            $fichaUsuario = FichaUsuario::where('id_ficha', $ficha->uuid)->where('user_id', $usuarioFicha->id)->first();
            if ($fichaUsuario) {
                $usuarioFicha->marcado = true;
                $usuarioFicha->invitados = $fichaUsuario->invitados;
            } else {
                $usuarioFicha->marcado = false;
                $usuarioFicha->invitados = 0;
            }
        }
        return redirect()->route('fichas.usuarios', compact('uuid'))->with('success', 'Usuarios de la ficha actualizados con éxito');
    }

    public function updateservicios($uuid, Request $request)
    {
        FichaServicio::where('id_ficha', $uuid)->delete();
        if ($request->servicios != null) {
            foreach ($request->servicios as $servicio) {
                FichaServicio::create([
                    'uuid' => (string) Uuid::uuid4(),
                    'id_ficha' => $uuid,
                    'id_servicio' => $servicio,
                    'precio' => Servicio::find($servicio)->precio
                ]);
            }
        }
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $serviciosFicha = Servicio::orderBy('nombre')->get();
        foreach ($serviciosFicha as $servicioFicha) {
            //si el id_servicio está en FichaServicio de la ficha lo ponemos como marcado
            $fichaServicio = FichaServicio::where('id_ficha', $ficha->uuid)->where('id_servicio', $servicioFicha->uuid)->first();
            if ($fichaServicio) {
                $servicioFicha->marcado = true;
            } else {
                $servicioFicha->marcado = false;
            }
        }
        return redirect()->route('fichas.servicios', compact('uuid'))->with('success', 'Servicios de la ficha actualizados con éxito');
    }

    public function servicios($uuid)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $serviciosFicha = Servicio::orderBy('nombre')->get();
        foreach ($serviciosFicha as $servicioFicha) {
            //si el id_servicio está en FichaServicio de la ficha lo ponemos como marcado
            $fichaServicio = FichaServicio::where('id_ficha', $ficha->uuid)->where('id_servicio', $servicioFicha->uuid)->first();
            if ($fichaServicio) {
                $servicioFicha->marcado = true;
            } else {
                $servicioFicha->marcado = false;
            }
        }
        return view('fichas.servicios', compact('ficha', 'serviciosFicha'));
    }



    public function addproduct(Request $request)
    {
        $ficha = Ficha::find($request->idFicha);
        $familia = Familia::find($request->idFamilia);
        $producto = Producto::find($request->idProducto);
        $existe = FichaProducto::where('id_ficha', $ficha->uuid)->where('id_producto', $producto->id)->first();
        if ($existe) {
            $existe->cantidad += 1;
            $existe->precio += $producto->precio;
            $existe->save();
        } else {
            $fichaProducto = FichaProducto::create([
                'uuid' => (string) Uuid::uuid4(),
                'id_ficha' => $ficha->uuid,
                'id_producto' => $producto->uuid,
                'precio' => $producto->precio,
                'cantidad' => 1
            ]);
        }
        $productos = Producto::where('familia', $familia)->orderBy('posicion')->get();
        return redirect()->route('fichas.productos', [
            'uuid' => $ficha,
            'uuid2' => $familia
        ])->with('success', $producto->nombre . ' añadido a la ficha');;
    }

    public function lista($uuid)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $productosFicha = FichaProducto::where('id_ficha', $uuid)
            ->groupBy('id_producto')
            ->selectRaw('id_producto, sum(cantidad) as cantidad, sum(precio) as precio') // Calculate the total quantity and total price
            ->get();

        foreach ($productosFicha as $productoFicha) {
            $productoFicha->borrable = true;
            $productoFicha->producto = Producto::find($productoFicha->id_producto);
        }

        return view('fichas.lista', compact('ficha', 'productosFicha'));
    }

    public function destroylista(string $uuid, string $uuid2)
    {
        //buscar en fichaproducto la ficha con id_ficha = uuid y id_producto = uuid2
        $fichaProductos = FichaProducto::where('id_ficha', $uuid)->where('id_producto', $uuid2)->get();
        foreach ($fichaProductos as $fichaProducto) {
            $fichaProducto->delete();
        }
        return redirect()->route('fichas.lista', $uuid)
            ->with('success', 'Producto eliminado de la ficha');
    }

    public function updatelista(string $uuid, string $uuid2, int $cantidad)
    {
        //Buscar el total del producto de la ficha en FichaProducto
        //Si la cantidad es positiva insertar un elemento en FichaProducto
        //Si la cantidad es negativa eliminar un elemento en FichaProducto
        $total = FichaProducto::where('id_ficha', $uuid)->where('id_producto', $uuid2)->sum('cantidad');
        $producto = Producto::find($uuid2);
        if ($cantidad > 0) {
            $fichaProducto = FichaProducto::create([
                'uuid' => (string) Uuid::uuid4(),
                'id_ficha' => $uuid,
                'id_producto' => $uuid2,
                'precio' => $producto->precio,
                'cantidad' => $cantidad
            ]);
            return redirect()->route('fichas.lista', $uuid)
                ->with('success', 'Producto añadido a la ficha');
        } else {
            $fichaProductos = FichaProducto::where('id_ficha', $uuid)->where('id_producto', $uuid2)->take(abs($cantidad))->get();
            foreach ($fichaProductos as $fichaProducto) {
                $fichaProducto->delete();
            }
            return redirect()->route('fichas.lista', $uuid)
                ->with('success', 'Producto eliminado de la ficha');
        }
    }
}
