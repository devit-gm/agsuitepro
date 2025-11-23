<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\Site;

class MailConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        try {
            // Obtener el dominio actual
            $domain = request()->getHost();
            $site = Site::where('dominio', $domain)->first();
            
            if ($site && $site->mail_host) {
                // Configurar el mailer por defecto
                Config::set('mail.default', 'smtp');
                
                // Configurar el nombre de la aplicación con el nombre del sitio
                Config::set('app.name', $site->nombre);
                Config::set('mail.mailers.smtp.transport', 'smtp');
                Config::set('mail.mailers.smtp.host', $site->mail_host);
                Config::set('mail.mailers.smtp.port', $site->mail_port ?? 587);
                Config::set('mail.mailers.smtp.encryption', $site->mail_encryption ?? 'tls');
                Config::set('mail.mailers.smtp.username', $site->mail_username);
                Config::set('mail.mailers.smtp.password', $site->mail_password);
                Config::set('mail.from.address', $site->mail_from_address ?? $site->mail_username);
                Config::set('mail.from.name', $site->mail_from_name ?? $site->nombre);
            }
        } catch (\Exception $e) {
            // Si hay error, usar valores por defecto del .env
        }
    }

    public function register()
    {
        //
    }
}
