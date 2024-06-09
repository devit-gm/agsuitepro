<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SitiosController extends Controller
{
    public function __construct()
    {
    }

    public function show(Request $request)
    {
        $domain = $request->getHost();
        $site = Site::where('dominio', $domain)->first();

        if (!$site) {
            abort(404, 'Site not found.');
        }

        if ($site->central == 1) {
            // Aquí podrías devolver una vista con los detalles del sitio
            return redirect()->route('sitios.index');
        } else {
            return redirect()->route('fichas.index');
        }
    }

    public function index()
    {
        $this->middleware(function ($request, $next) {
            $domain = $request->getHost();
            $site = Site::where('dominio', $domain)->first();
            if ($site->central == 0) {
                abort(403, 'No tiene acceso a este recurso.');
            }

            return $next($request);
        });

        $sites = Site::where('central', 0)->orderBy('id')->get();
        //Calcular el numero de usuarios del sitio en base a la tabla de usuarios
        foreach ($sites as $site) {
            $site->usuarios = DB::connection('central')->table('users')->where('site_id', $site->id)->count();
        }
        return view('sitios.index', compact('sites'));
    }

    public function create()
    {
        return view('sitios.create');
    }

    public function edit($id)
    {
        $site = Site::find($id);
        return view('sitios.edit', compact('site'));
    }

    public function update(Request $request, $id)
    {
        $site = Site::find($id);
        $site->nombre = $request->nombre;
        $site->dominio = $request->dominio;
        $site->ruta_logo = $request->ruta_logo;
        $site->ruta_logo_nav = $request->ruta_logo_nav;
        $site->ruta_estilos = $request->ruta_estilos;
        $site->db_host = $request->db_host;
        $site->db_name = $request->db_name;
        $site->db_user = $request->db_user;
        $site->db_password = $request->db_password;
        $site->central = $request->central;
        $site->save();
        return redirect()->route('sitios.index')->with('success', 'Sitio actualizado con éxito');
    }

    public function destroy($id)
    {
        $site = Site::find($id);
        $site->delete();
        return redirect()->route('sitios.index')->with('success', 'Sitio eliminado con éxito');
    }
}
