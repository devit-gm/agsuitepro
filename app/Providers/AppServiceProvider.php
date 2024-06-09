<?php

namespace App\Providers;

use App\Models\License;
use Illuminate\Support\ServiceProvider;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        $domain = $request->getHost();



        $site = Site::where('dominio', $domain)->first();

        if (!$site) {
            abort(404, 'Site not found.');
        }

        app()->instance('site', $site);



        config(['database.connections.site' => [
            'driver' => 'mysql',
            'host' => $site->db_host,
            'database' => $site->db_name,
            'username' => $site->db_user,
            'password' => $site->db_password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ]]);

        // Configurar paths específicos del sitio
        config(['site.logo' => $site->ruta_logo]);
        config(['site.name' => $site->nombre]);
        config(['site.logoNav' => $site->ruta_logo_nav]);
        config(['site.styles' => $site->ruta_estilos]);

        Log::info('Configuración de la base de datos del sitio activo:', [
            'host' => $site->db_host,
            'database' => $site->db_name,
            'username' => $site->db_user,
            'password' => $site->db_password,
        ]);

        $this->defineSiteRoutes($site);
    }

    protected function defineSiteRoutes($site)
    {
        $siteId = $site->id;

        Route::domain($site->dominio)->group(function () use ($siteId) {
            Route::get('/', 'App\Http\Controllers\SitiosController@show')->name("site{$siteId}.home");
        });
    }
}
