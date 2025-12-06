<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManifestController extends Controller
{
    public function show()
    {
        // Obtener configuración del sitio actual
        $siteName = siteName();
        $siteUrl = url('/');
        
        // Obtener ajustes para el tema de color
        try {
            $ajustes = DB::connection('site')->table('ajustes')->first();
            $themeColor = '#a7380d'; // Color rojo por defecto
        } catch (\Exception $e) {
            $themeColor = '#a7380d';
        }
        
        // Obtener carpeta PWA configurada para este sitio
        $domain = request()->getHost();
        $site = \App\Models\Site::where('dominio', $domain)->first();
        
        // Configurar iconos según la carpeta configurada en el sitio
        if ($site && $site->carpeta_pwa) {
            $carpetaPWA = trim($site->carpeta_pwa, '/');
            $basePath = '/' . $carpetaPWA;
        } else {
            // Por defecto usar images/icons
            $basePath = '/images/icons';
        }
        
        // Definir todos los tamaños de iconos
        $iconSizes = [24, 32, 48, 72, 96, 128, 144, 152, 192, 384, 512];
        $icons = [];
        
        foreach ($iconSizes as $size) {
            $icons[] = [
                'src' => asset($basePath . '/icon-' . $size . 'x' . $size . '.png'),
                'sizes' => $size . 'x' . $size,
                'type' => 'image/png',
                'purpose' => 'any maskable'
            ];
        }
        
        $manifest = [
            'name' => $siteName,
            'short_name' => $siteName,
            'description' => 'Sistema de gestión para restaurantes y eventos',
            'start_url' => $siteUrl,
            'display' => 'standalone',
            'background_color' => '#ffffff',
            'theme_color' => $themeColor,
            'orientation' => 'portrait-primary',
            'icons' => $icons,
            'categories' => ['business', 'productivity'],
            'lang' => 'es-ES',
            'dir' => 'ltr'
        ];
        
        return response()->json($manifest)
            ->header('Content-Type', 'application/manifest+json')
            ->header('Cache-Control', 'public, max-age=86400'); // Cache por 24 horas
    }
}
