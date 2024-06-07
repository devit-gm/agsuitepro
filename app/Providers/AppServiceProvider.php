<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Site;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

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
        // First purge the configuration to remove config details from cache 
        DB::purge('agsuite');
        // set the database config details 
        Config::set("database.connections.agsuite.host", $site->db_host);
        Config::set("database.connections.agsuite.driver", "mysql");
        Config::set("database.connections.agsuite.database", $site->db_name);
        Config::set("database.connections.agsuite.username", $site->db_user);
        Config::set("database.connections.agsuite.password", $site->db_password);



        DB::setDefaultConnection("agsuite");
    }
}
