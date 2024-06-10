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

if (!function_exists('siteStyles')) {
    function siteStyles()
    {
        return config('site.styles') ? asset(config('site.styles')) : asset('css/app.css');
    }
}
