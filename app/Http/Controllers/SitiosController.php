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

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cif' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'telefono' => 'nullable|string|max:20',
            'dominio' => 'required|string|max:255|unique:sitios,dominio',
            'logo' => 'required|string|max:255',
            'logo_nav' => 'nullable|string|max:255',
            'favicon' => 'nullable|string|max:255',
            'estilos' => 'nullable|string|max:255',
            'db_host' => 'required|string|max:255',
            'db_name' => 'required|string|max:255',
            'db_user' => 'required|string|max:255',
            'db_password' => 'required|string|max:255',
            'mail_mailer' => 'nullable|string|max:255',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|max:255',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'carpeta_pwa' => 'nullable|string|max:100'
        ]);

        $sitio = new Site();
        $sitio->nombre = $request->nombre;
        $sitio->cif = $request->cif;
        $sitio->direccion = $request->direccion;
        $sitio->telefono = $request->telefono;
        $sitio->dominio = $request->dominio;
        $sitio->ruta_logo = $request->logo;
        $sitio->ruta_logo_nav = $request->logo_nav;
        $sitio->favicon = $request->favicon;
        $sitio->ruta_estilos = $request->estilos;
        $sitio->carpeta_pwa = $request->carpeta_pwa;
        $sitio->db_host = $request->db_host;
        $sitio->db_name = $request->db_name;
        $sitio->db_user = $request->db_user;
        $sitio->db_password = $request->db_password;
        $sitio->central = $request->has('central') ? 1 : 0;
        
        // Configuración de correo
        $sitio->mail_mailer = $request->mail_mailer;
        $sitio->mail_host = $request->mail_host;
        $sitio->mail_port = $request->mail_port;
        $sitio->mail_username = $request->mail_username;
        $sitio->mail_password = $request->mail_password;
        $sitio->mail_encryption = $request->mail_encryption;
        $sitio->mail_from_address = $request->mail_from_address;
        $sitio->mail_from_name = $request->mail_from_name;
        
        // Configuración de idioma
        $sitio->locale = $request->locale ?? 'es';

        $sitio->save();

        return redirect()->route('sitios.index')->with('success', __('Sociedad creada correctamente'));
    }

    public function edit($id)
    {
        $sitio = Site::findOrFail($id);
        return view('sitios.edit', compact('sitio'));
    }

    public function update(Request $request, $id)
    {
        $sitio = Site::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cif' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'telefono' => 'nullable|string|max:20',
            'dominio' => 'required|string|max:255|unique:sitios,dominio,' . $id,
            'logo' => 'nullable|string|max:255',
            'logo_nav' => 'nullable|string|max:255',
            'favicon' => 'nullable|string|max:255',
            'estilos' => 'nullable|string|max:255',
            'db_host' => 'required|string|max:255',
            'db_name' => 'required|string|max:255',
            'db_user' => 'required|string|max:255',
            'db_password' => 'required|string|max:255',
            'mail_mailer' => 'nullable|string|max:255',
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|max:255',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'carpeta_pwa' => 'nullable|string|max:100',
        ]);

        $sitio->nombre = $request->nombre;
        $sitio->cif = $request->cif;
        $sitio->direccion = $request->direccion;
        $sitio->telefono = $request->telefono;
        $sitio->dominio = $request->dominio;
        $sitio->central = $request->has('central') ? 1 : 0;
        
        // Actualizar rutas de archivos si se proporcionan
        if ($request->filled('logo')) {
            $sitio->ruta_logo = $request->logo;
        }
        if ($request->filled('logo_nav')) {
            $sitio->ruta_logo_nav = $request->logo_nav;
        }
        if ($request->filled('favicon')) {
            $sitio->favicon = $request->favicon;
        }
        if ($request->filled('estilos')) {
            $sitio->ruta_estilos = $request->estilos;
        }
        
        // Configuración de base de datos
        $sitio->db_host = $request->db_host;
        $sitio->db_name = $request->db_name;
        $sitio->db_user = $request->db_user;
        $sitio->db_password = $request->db_password;
        
        // Configuración de correo
        $sitio->mail_mailer = $request->mail_mailer;
        $sitio->mail_host = $request->mail_host;
        $sitio->mail_port = $request->mail_port;
        $sitio->mail_username = $request->mail_username;
        $sitio->mail_password = $request->mail_password;
        $sitio->mail_encryption = $request->mail_encryption;
        $sitio->mail_from_address = $request->mail_from_address;
        $sitio->mail_from_name = $request->mail_from_name;
        
        // Configuración de idioma
        $sitio->locale = $request->locale ?? $sitio->locale ?? 'es';
        
        // Carpeta PWA
        $sitio->carpeta_pwa = $request->carpeta_pwa;

        $sitio->save();

        return redirect()->route('sitios.edit', $id)->with('success', __('Sociedad actualizada correctamente'));
    }

    public function destroy($id)
    {
        $sitio = Site::findOrFail($id);

        if ($sitio->borrable != 1) {
            return redirect()->route('sitios.index')->with('error', __('No se puede eliminar esta sociedad'));
        }

        // Eliminar logo si existe
        if ($sitio->ruta_logo && file_exists(public_path($sitio->ruta_logo))) {
            unlink(public_path($sitio->ruta_logo));
        }

        $sitio->delete();

        return redirect()->route('sitios.index')->with('success', __('Sociedad eliminada correctamente'));
    }
}
