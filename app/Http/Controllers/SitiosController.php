<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SitiosController extends Controller
{
    public function show(Request $request)
    {
        $domain = $request->getHost();

        // Buscar el sitio basado en el dominio
        $site = Site::where('domain', $domain)->first();
        dd($site);
        if (!$site) {
            abort(404, 'Site not found.');
        }

        // Aquí podrías devolver una vista con los detalles del sitio
        return view('site.show', compact('site'));
    }
}
