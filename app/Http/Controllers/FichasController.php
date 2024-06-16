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
use App\Models\FichaRecibo;
use App\Models\Producto;
use App\Models\Site;
use Ramsey\Uuid\Type\Decimal;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FichasController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $domain = $request->getHost();
            $site = Site::where('dominio', $domain)->first();
            if ($site->central == 1) {
                abort(403, 'No tiene acceso a este recurso.');
            } else {
                return $next($request);
            }
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Carbon::setLocale('es');
        if ($request->method() == "GET") {
            $fichasMostrar = Ficha::whereDate('fecha', '>=', Carbon::now()->toDateString())
                ->where('estado', 0)
                ->orderBy('fecha')
                ->get();
        } else {
            if ($request->incluir_cerradas == 0) {
                $fichasMostrar = Ficha::whereDate('fecha', '>=', Carbon::now()->toDateString())
                    ->where('estado', 0)
                    ->orderBy('fecha')
                    ->get();
            } else {
                $fichasMostrar = Ficha::whereDate('fecha', '>=', Carbon::now()->toDateString())
                    ->orderBy('fecha')
                    ->get();
            }
        }
        $fichas = [];
        foreach ($fichasMostrar as $ficha) {
            if ($ficha->tipo != 4) {
                //Si la ficha no es de tipo evento
                //La mostramos solo para el usuario activo
                //O para el administrador
                //O para los usuarios que están en el grupo de la ficha
                if ($ficha->user_id == Auth::id() || Auth::user()->role_id == 1 || FichaUsuario::where('id_ficha', $ficha->uuid)->where('user_id', Auth::id())->first()) {
                    $fichas[] = $ficha;
                }
            } else {
                //Los eventos los mostramos para todos por si los
                //usuarios quieren apuntarse
                $fichas[] = $ficha;
            }
        }
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
                if ($ficha->estado == 0)
                    $ficha->borrable = true;
                else
                    $ficha->borrable = false;
            } else {
                $ficha->borrable = false;
            }
        }
        $errors = new \Illuminate\Support\MessageBag();
        if ($fichas == null || count($fichas) == 0) {
            $errors->add('msg', 'No se encontraron fichas para mostrar.');
            return view('fichas.index', compact('fichas', 'errors', 'request'));
        } else {
            return view('fichas.index', compact('fichas', 'request'));
        }
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
            'fecha' => $request->fecha,
            'hora' => $request->hora
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
        $fechaCambiada = Carbon::parse($ficha->fecha)->todateTimeString();
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
            'fecha' => $request->fecha,
            'hora' => $request->hora
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
        $ajustes = DB::connection('site')->table('ajustes')->first();
        $productos = FichaProducto::where('id_ficha', $ficha->uuid)->get();
        foreach ($productos as $producto) {
            $precio += $producto->precio;
        }
        $usuarios = FichaUsuario::where('id_ficha', $ficha->uuid)->get();
        foreach ($usuarios as $usuario) {
            $num_invitados = $usuario->invitados;
            if ($num_invitados > $ajustes->max_invitados_cobrar) {
                $num_invitados = $ajustes->max_invitados_cobrar;
            }
            if ($ajustes->primer_invitado_gratis && $num_invitados > 0) {
                $num_invitados--;
            }
            $precio += $num_invitados * $ajustes->precio_invitado;
        }
        $servicios = FichaServicio::where('id_ficha', $ficha->uuid)->get();
        foreach ($servicios as $servicio) {
            $precio += $servicio->precio;
        }
        if ($ajustes->activar_invitados_grupo) {
            if ($ficha->invitados_grupo > 0) {
                $precio = $precio + $ficha->invitados_grupo;
            }
        }
        return $precio;
    }

    public function familias(string $uuid)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $familias = Familia::orderBy('posicion')->get();
        //Si no es un evento y el usuario activo no está en la ficha lo añadimos
        if ($ficha->tipo != 4) {
            $estaUsuarioActivo = FichaUsuario::where('id_ficha', $ficha->uuid)->where('user_id', Auth::id())->first();
            if (!$estaUsuarioActivo) {
                //Si el usuario activo no está en la ficha lo añadimos
                FichaUsuario::create([
                    'uuid' => (string) Uuid::uuid4(),
                    'id_ficha' => $ficha->uuid,
                    'user_id' => Auth::id(),
                    'invitados' => 0
                ]);
            }
        }
        //Si es un evento no hacemos nada
        //Para que los usuarios puedan apuntarse o no
        return view('fichas.familias', compact('ficha', 'familias'));
    }

    public function productos($uuid, $uuid2)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $familia = Familia::find($uuid2);
        $ajustes = DB::connection('site')->table('ajustes')->first();
        if ($ajustes->permitir_comprar_sin_stock == 1) {
            $productos = Producto::where('familia', $uuid2)->orderBy('posicion')->get();
        } else {
            $productos = Producto::where('familia', $uuid2)->where('stock', '>', 0)->orderBy('posicion')->get();
        }
        return view('fichas.productos', compact('ficha', 'familia', 'productos'));
    }

    public function usuarios($uuid)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $site = app('site');
        //Si es una ficha individual sólo mostramos al usuario activo
        if ($ficha->tipo == 1) {
            $usuariosFicha = User::where('site_id', $site->id)->where('id', $ficha->user_id)->get();
        } else {
            $usuariosFicha = User::where('site_id', $site->id)->orderBy('id')->get();
        }
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

    public function resumen($uuid)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $ficha->productos = FichaProducto::where('id_ficha', $uuid)->get();
        $total_consumos = 0;
        foreach ($ficha->productos as $producto) {
            $total_consumos += $producto->precio;
        }
        $ficha->total_consumos = $total_consumos;
        $ficha->servicios = FichaServicio::where('id_ficha', $uuid)->get();
        $total_servicios = 0;
        foreach ($ficha->servicios as $servicio) {
            $total_servicios += $servicio->precio;
        }
        $ficha->total_servicios = $total_servicios;
        $ficha->usuarios = FichaUsuario::where('id_ficha', $uuid)->get();

        $total_comensales = 0;
        foreach ($ficha->usuarios as $usuario) {
            $total_comensales += $usuario->invitados;
            $total_comensales++;
        }
        // De momento los invitados de grupo no cuentan
        // if ($ficha->invitados_grupo > 0) {
        //     $total_comensales += $ficha->invitados_grupo;
        // }
        $ficha->total_comensales = $total_comensales;
        $ficha->gastos = FichaGasto::where('id_ficha', $uuid)->get();
        $total_gastos = 0;
        foreach ($ficha->gastos as $gasto) {
            $total_gastos += $gasto->precio;
        }
        $ficha->total_gastos = $total_gastos;

        $ficha->precio_comensal = $ficha->precio / $total_comensales;
        return view('fichas.resumen', compact('ficha'));
    }

    public function enviar($uuid)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $gastosFicha = FichaGasto::where('id_ficha', $uuid)->get();
        //Insertamos en la tabla ficha_recibos los gastos de la ficha
        foreach ($gastosFicha as $gastoFicha) {
            FichaRecibo::create([
                'uuid' => (string) Uuid::uuid4(),
                'id_ficha' => $uuid,
                'user_id' => $gastoFicha->user_id,
                'tipo' => 2,
                'estado' => 0,
                'precio' => $gastoFicha->precio,
                'fecha' => Carbon::now()
            ]);
        }
        //Obtenemos el precio total por comensal
        $total_comensales = 0;
        $usuarios = FichaUsuario::where('id_ficha', $uuid)->get();
        foreach ($usuarios as $usuario) {
            $total_comensales += $usuario->invitados;
            $total_comensales++;
        }
        // De momento los invitados de grupo no cuentan
        // if ($ficha->invitados_grupo > 0) {
        //     $total_comensales += $ficha->invitados_grupo;
        // }
        $precio_comensal = $ficha->precio / $total_comensales;
        //Insertamos en la tabla ficha_recibos el gasto por comensal
        //Que es el precio por comensal * número de invitados de cada usuario
        //Hay que añadir el gasto del propio comensal
        foreach ($usuarios as $usuario) {
            $num_invitados = $usuario->invitados;

            FichaRecibo::create([
                'uuid' => (string) Uuid::uuid4(),
                'id_ficha' => $uuid,
                'user_id' => $usuario->user_id,
                'tipo' => 1,
                'estado' => 0,
                //Sumamos 1 porque el propio comensal también paga
                'precio' => $precio_comensal * ($num_invitados + 1),
                'fecha' => Carbon::now()
            ]);
        }

        //Descontamos el stock de cada artículo consumido
        $productos = FichaProducto::where('id_ficha', $uuid)->get();
        foreach ($productos as $producto) {
            $productoFicha = Producto::where('uuid', $producto->id_producto)->first();
            if ($productoFicha->combinado == 1) {
                $productosCombinados = DB::connection('site')->table('composicion_productos')->where('id_producto', $productoFicha->uuid)->get();
                foreach ($productosCombinados as $productoCombinado) {
                    $producto2 = Producto::find($productoCombinado->id_componente);
                    $producto2->stock -= $producto->cantidad;
                    $producto2->save();
                }
            } else {
                $producto->producto = Producto::find($producto->id_producto);
                $producto->producto->stock -= $producto->cantidad;
                $producto->producto->save();
            }
        }

        $ficha->estado = 1;
        $ficha->save();
        return redirect()->route('fichas.index')
            ->with('success', 'Ficha enviada con éxito');
    }

    public function gastos($uuid)
    {
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $gastosFicha = FichaGasto::where('id_ficha', $uuid)->get();
        foreach ($gastosFicha as $gastoFicha) {
            $gastoFicha->usuario = User::find($gastoFicha->user_id);
            $gastoFicha->borrable = true;
        }

        //Si es una ficha de compra ha llegado directamente
        //Hay que comprobar si el usuario activo está en la ficha
        if ($ficha->tipo == 3) {
            $estaUsuarioActivo = FichaUsuario::where('id_ficha', $ficha->uuid)->where('user_id', Auth::id())->first();
            if (!$estaUsuarioActivo) {
                //Si el usuario activo no está en la ficha lo añadimos
                FichaUsuario::create([
                    'uuid' => (string) Uuid::uuid4(),
                    'id_ficha' => $ficha->uuid,
                    'user_id' => Auth::id(),
                    'invitados' => 0
                ]);
            }
        }
        //Para el resto de tipos de ficha no hacemos nada ya que se 
        //controla en otro sitio.
        $errors = new \Illuminate\Support\MessageBag();
        if ($gastosFicha == null || count($gastosFicha) == 0) {
            $errors->add('msg', 'No se han introducido gastos.');
            return view('fichas.gastos', compact('ficha', 'gastosFicha', 'errors'));
        } else {
            return view('fichas.gastos', compact('ficha', 'gastosFicha'));
        }
    }

    public function addgastos($uuid)
    {
        $site = app('site');
        $ficha = Ficha::find($uuid);
        $ficha->precio = $this->ObtenerImporteFicha($ficha);
        $usuariosFicha = FichaUsuario::where('id_ficha', $uuid)->get();
        if ($usuariosFicha == null) {
            $usuariosFicha = User::where('id', $ficha->user_id)->get();
        } else {
            $usuariosFicha = [];
            //Buscar los usuarios que están dentro de FichaUsuario
            $usuarios = User::where('site_id', $site->id)->orderBy('id')->get();
            foreach ($usuarios as $usuario) {
                //si el user_id está en FichaUsuario de la ficha lo ponemos como marcado
                $fichaUsuario = FichaUsuario::where('id_ficha', $ficha->uuid)->where('user_id', $usuario->id)->first();
                if ($fichaUsuario) {
                    $usuariosFicha[] = $usuario;
                }
            }
        }
        return view('fichas.addgastos', compact('ficha', 'usuariosFicha'));
    }

    public function destroygastos(string $uuid, string $uuid2)
    {

        //buscar en fichaproducto la ficha con id_ficha = uuid y id_producto = uuid2
        $fichaGastos = FichaGasto::where('id_ficha', $uuid)->where('uuid', $uuid2)->get();
        foreach ($fichaGastos as $fichaGasto) {
            if (File::exists(public_path('images') . '/'  . $fichaGasto->ticket)) {
                File::delete(public_path('images') . '/'  . $fichaGasto->ticket);
            }
            $fichaGasto->delete();
        }
        return redirect()->route('fichas.gastos', $uuid)
            ->with('success', 'Gasto eliminado de la ficha');
    }

    public function updategastos($uuid, Request $request)
    {
        if ($request->ticket == null) {
            $request->validate([
                'descripcion' => 'max:255',
                'precio' => 'required'
            ]);
            $fichaGasto = FichaGasto::create([
                'uuid' => (string) Uuid::uuid4(),
                'id_ficha' => $uuid,
                'user_id' => Auth::id(),
                'descripcion' => $request->descripcion,
                'ticket' => '',
                'precio' => $request->precio
            ]);
        } else {
            $request->validate([
                'descripcion' => 'max:255',
                'ticket' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'precio' => 'required'
            ]);

            $imageName = time() . '.' . $request->ticket->extension();
            $request->ticket->move(public_path('images'), $imageName);

            $fichaGasto = FichaGasto::create([
                'uuid' => (string) Uuid::uuid4(),
                'id_ficha' => $uuid,
                'user_id' => Auth::id(),
                'descripcion' => $request->descripcion,
                'ticket' => $imageName,
                'precio' => $request->precio
            ]);
        }

        return redirect()->route('fichas.gastos', $uuid)->with('success', 'Gastos de la ficha actualizados con éxito');
    }

    public function updateusuarios($uuid, Request $request)
    {
        $site = app('site');
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
        $usuariosFicha = User::where('site_id', $site->id)->orderBy('id')->get();
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
        //Si el producto es combinado hay que sumar el precio de sus componentes
        if ($producto->combinado == 1) {
            $productosCombinados = DB::connection('site')->table('composicion_productos')->where('id_producto', $producto->uuid)->get();
            $precio = 0;
            foreach ($productosCombinados as $productoCombinado) {
                $producto2 = Producto::find($productoCombinado->id_componente);
                $precio += $producto2->precio;
            }
            $producto->precio = $precio;
        }
        $cantidad = 1;
        $existe = FichaProducto::where('id_ficha', $ficha->uuid)->where('id_producto', $producto->id)->first();
        if ($existe) {
            $existe->cantidad += $cantidad;
            $existe->precio += ($producto->precio * $cantidad);
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
        if ($producto->combinado == 1) {
            $productosCombinados = DB::connection('site')->table('composicion_productos')->where('id_producto', $producto->uuid)->get();
            $precio = 0;
            foreach ($productosCombinados as $productoCombinado) {
                $producto2 = Producto::find($productoCombinado->id_componente);
                $precio += $producto2->precio;
            }
            $producto->precio = $precio;
        }
        if ($cantidad > 0) {
            for ($cantidad; $cantidad > 0; $cantidad--) {
                $fichaProducto = FichaProducto::create([
                    'uuid' => (string) Uuid::uuid4(),
                    'id_ficha' => $uuid,
                    'id_producto' => $uuid2,
                    'precio' => $producto->precio,
                    'cantidad' => 1
                ]);
            }
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
