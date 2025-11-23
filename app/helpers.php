<?php

if (!function_exists('siteLogo')) {
    function siteLogo()
    {
        return config('site.logo') ? asset(config('site.logo')) : asset('images/logo.png');
    }
}

if (!function_exists('siteName')) {
    function siteName()
    {
        return config('site.name') ? config('site.name') : config('app.name');
    }
}

if (!function_exists('siteLogoNav')) {
    function siteLogoNav()
    {
        return config('site.logoNav') ? asset(config('site.logoNav')) : asset('images/logo-nav.png');
    }
}

if (!function_exists('siteFavicon')) {
    function siteFavicon()
    {
        return config('site.favicon') ? asset(config('site.favicon')) : asset('images/favicon');
    }
}

if (!function_exists('getInitials')) {
    function getInitials($string)
    {
        $words = explode(' ', $string);
        $initials = '';

        foreach ($words as $word) {
            $initials .= substr($word, 0, 1);
        }

        return strtoupper($initials);
    }
}

if (!function_exists('siteStyles')) {
    function siteStyles()
    {
        return config('site.styles') ? asset(config('site.styles')) : asset('css/app.css');
    }
}

if (!function_exists('fichaRoute')) {
    /**
     * Genera una ruta dinámica basada en el modo de operación (fichas o mesas)
     * 
     * @param string $action Nombre de la acción (ej: 'index', 'lista', 'familias')
     * @param array $parameters Parámetros de la ruta
     * @return string URL generada
     */
    function fichaRoute($action, $parameters = [])
    {
        $ajustes = \App\Models\Ajustes::first();
        $modoOperacion = $ajustes->modo_operacion ?? 'fichas';
        
        $prefix = $modoOperacion === 'mesas' ? 'mesas' : 'fichas';
        
        // Ajustar nombre de ruta para resumen-final en mesas
        if ($action === 'resumen' && $prefix === 'mesas') {
            return route("{$prefix}.resumen-final", $parameters);
        }
        
        return route("{$prefix}.{$action}", $parameters);
    }
}

if (!function_exists('cachedImage')) {
    /**
     * Genera URL de imagen con cache busting y lazy loading
     * 
     * @param string $imagePath Ruta relativa de la imagen (ej: 'producto.jpg')
     * @param bool $version Agregar versión basada en última modificación
     * @return string URL completa de la imagen
     */
    function cachedImage($imagePath, $version = true)
    {
        if (empty($imagePath)) {
            return asset('images/default.png');
        }
        
        $url = asset('images/' . $imagePath);
        
        // Agregar versión basada en timestamp del archivo para cache busting
        if ($version) {
            $filePath = public_path('images/' . $imagePath);
            if (file_exists($filePath)) {
                $timestamp = filemtime($filePath);
                $url .= '?v=' . $timestamp;
            }
        }
        
        return $url;
    }
}

if (!function_exists('optimizedImageTag')) {
    /**
     * Genera etiqueta <img> optimizada con lazy loading y dimensiones
     * 
     * @param string $imagePath Ruta de la imagen
     * @param string $alt Texto alternativo
     * @param int $width Ancho en píxeles
     * @param int $height Alto en píxeles (opcional)
     * @param string $classes Clases CSS adicionales
     * @return string HTML de la etiqueta img
     */
    function optimizedImageTag($imagePath, $alt = '', $width = null, $height = null, $classes = 'img-fluid rounded')
    {
        $url = cachedImage($imagePath);
        
        $attributes = [
            'src' => $url,
            'alt' => $alt,
            'class' => $classes,
            'loading' => 'lazy', // Lazy loading nativo
            'decoding' => 'async' // Decodificación asíncrona
        ];
        
        if ($width) {
            $attributes['width'] = $width;
        }
        
        if ($height) {
            $attributes['height'] = $height;
        }
        
        $attrString = '';
        foreach ($attributes as $key => $value) {
            $attrString .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }
        
        return '<img' . $attrString . ' />';
    }
}
