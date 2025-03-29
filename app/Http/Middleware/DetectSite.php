<?php

namespace App\Http\Middleware;

use App\Models\License;
use App\Models\Site;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;


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

        // Si el sitio no existe, permitir continuar la solicitud
        // para que otros middlewares puedan manejar la respuesta adecuada
        if (!$site) {
            return $next($request);
        }

        $user = Auth::user();
        if ($request->route() && $request->route()->getName() == "home") {
            return redirect('/');
        }

        if ($user) {
            if ($site->central == 0) {
                // Solo verificar licencia si hay una ruta definida y no es la página de error
                if ($request->route() && $request->route()->getName() != 'licencias.error') {
                    if ($user->role_id != 1) {
                        $license = License::where('site_id', $site->id)
                            ->where('user_id', $user->id)
                            ->first();

                        if (!$license || Carbon::parse($license->expires_at)->isPast() || $license->actived == 0) {
                            return redirect()->route('licencias.error')->with('success');
                        }
                    }
                }
            }
        }
        return $next($request);
    }
}
