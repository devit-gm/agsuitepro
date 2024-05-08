<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Console\View\Components\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::orderBy('id')->get();
        $roles = Role::orderBy('id')->get();
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
            'image' => 'image|mimes:png,jpg,jpeg|max:2048',
            'role_id' => 'required',
            'phone_number' => 'required'
        ]);
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        User::create([
            'name' => $request->name,
            'image' => $imageName,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role_id' => $request->role_id,
            'phone_number' => $request->phone_number
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
            'image' => 'image|mimes:png,jpg,jpeg|max:2048',
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
        $roles = Role::orderBy('Name')->get();
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

        $roles = Role::orderBy('Name')->get();
        return view('usuarios.edit', compact('usuario'), compact('roles'));
    }
}
