<?php

if (!function_exists('siteLogo')) {
    function siteLogo()
    {
        return config('site.logo') ? asset(config('site.logo')) : asset('images/logo.png');
    }
}

if (!function_exists('siteLogoNav')) {
    function siteLogoNav()
    {
        return config('site.logoNav') ? asset(config('site.logoNav')) : asset('images/logo-nav.png');
    }
}

if (!function_exists('siteStyles')) {
    function siteStyles()
    {
        return config('site.styles') ? asset(config('site.styles')) : asset('css/app.css');
    }
}