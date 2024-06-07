<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Site;

class SiteServiceProvider extends ServiceProvider
{
    public function register()
    {
        // No es necesario agregar lógica aquí para este caso
    }

    public function boot()
    {
    }
}
