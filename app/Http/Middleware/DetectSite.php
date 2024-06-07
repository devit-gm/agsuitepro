<?php

namespace App\Http\Middleware;

use App\Models\Site;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;

class DetectSite
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $domain = $request->getHost();



        $site = Site::where('dominio', $domain)->first();

        if (!$site) {
            abort(404, 'Site not found.');
        }

        app()->instance('site', $site);

        // Configurar paths específicos del sitio
        config(['site.logo' => $site->ruta_logo]);
        config(['site.logoNav' => $site->ruta_logo_nav]);
        config(['site.styles' => $site->ruta_estilos]);
        return $next($request);
    }
}
