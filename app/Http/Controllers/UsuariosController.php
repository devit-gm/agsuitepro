<?php

namespace App\Http\Controllers;

use App\Models\FichaUsuario;
use App\Models\Reserva;
use App\Models\Role;
use App\Models\Site;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\VerificarRolesService;
use Illuminate\Console\View\Components\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $verificarRolesService;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $usuario = Auth::user();
            $domain = $request->getHost();
            $site = Site::where('dominio', $domain)->first();
            if ($usuario->role_id > 2) {
                abort(403, 'No tiene acceso a este recurso.');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $site = app('site');
        $usuarios = User::where('site_id', $site->id)->orderBy('id')->get();
        $roles = Role::orderBy('id')->get();
        foreach ($usuarios as $usuario) {
            if ($usuario->role_id == 1) {
                $usuario->borrable = false;
            } else {
                //Si el usuario está en FichaUsuario o en Reservas no se puede borrar
                if (FichaUsuario::where('user_id', $usuario->uuid)->first() || Reserva::where('user_id', $usuario->uuid)->first()) {
                    $usuario->borrable = false;
                } else {
                    $usuario->borrable = true;
                }
            }
        }
        return view('usuarios.index', compact('usuarios', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3'],
            'image' => 'image|mimes:png,jpg,jpeg',
            'role_id' => 'required',
            'phone_number' => 'required'
        ]);
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $domain = $request->getHost();
        $site = Site::where('dominio', $domain)->first();

        User::create([
            'name' => $request->name,
            'image' => $imageName,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role_id' => $request->role_id,
            'phone_number' => $request->phone_number,
            'site_id' => $site->id
        ]);
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = User::find($id);
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'image' => 'image|mimes:png,jpg,jpeg',
            'role_id' => 'required',
            'phone_number' => 'required'
        ]);
        $usuario = User::find($id);

        if ($request->image != null) {
            if (File::exists(public_path('images') . '/'  . $usuario->image)) {
                File::delete(public_path('images') . '/'  . $usuario->image);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = $usuario->image;
        }

        $usuario->update([
            'name' => $request->name,
            'image' => $imageName,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'phone_number' => $request->phone_number
        ]);
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);
        if (File::exists(public_path('images') . '/'  . $usuario->image)) {
            File::delete(public_path('images') . '/'  . $usuario->image);
        }
        $usuario->delete();
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado con éxito');
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $usuario = User::orderBy('name')->get();
        $roles = Role::where('id', '>', 1)->orderBy('Name')->get();
        return view('usuarios.create', compact('usuario', 'roles'));
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $usuario = User::find($id);
        if ($usuario->role_id == 1) {
            $usuario->borrable = false;
        } else {
            //Si el usuario está en FichaUsuario o en Reservas no se puede borrar
            if (FichaUsuario::where('user_id', $usuario->uuid)->first() || Reserva::where('user_id', $usuario->uuid)->first()) {
                $usuario->borrable = false;
            } else {
                $usuario->borrable = true;
            }
        }
        $roles = Role::orderBy('Name')->get();
        return view('usuarios.edit', compact('usuario'), compact('roles'));
    }
}
