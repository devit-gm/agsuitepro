<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ siteName() }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ siteFavicon() }}-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ siteFavicon() }}-16x16.png">

    <!-- Scripts -->
    <link rel="stylesheet" href="{{ siteStyles() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>

    @guest
    <main class="py-3">
        @yield('content')
    </main>
    @else
    <nav class="navbar navbar-expand-md navbar-dark shadow-sm fondo-rojo">
        <div class="container col-md-12 col-sm-12 col-lg-12">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ siteLogoNav() }}" class="img-fluid logo-figure" alt="{{ siteName() }}"> {{ siteName() }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto ">
                    @if (app('site')->central == 0)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('fichas.*') || Request::is('/') ? 'active' : '' }}" href="{{ url('') }}">{{ __('Tokens') }}</a>
                    </li>
                    @if (Auth::user()->role_id < 3) <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ url('/usuarios') }}">Usuarios</a>
                        </li>
                        @endif
                        @if (Auth::user()->role_id < 4) <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('familias.*') ? 'active' : '' }}" href="{{ url('/familias') }}">{{ __('Families') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}" href="{{ url('/productos') }}">{{ __('Products') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('servicios.*') ? 'active' : '' }}" href="{{ url('/servicios') }}">{{ __('Services') }}</a>
                            </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('reservas.*') ? 'active' : '' }}" href="{{ url('/reservas') }}">{{ __('Bookings') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('informes.*') ? 'active' : '' }}" href="{{ url('/informes') }}">{{ __('Reports') }}</a>
                            </li>
                            @if (Auth::user()->role_id < 4) <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('ajustes.*') ? 'active' : '' }}" href="{{ url('/ajustes') }}">{{ __('Settings') }}</a>
                                </li>
                                @endif

                                @else
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('sitios.*') ? 'active' : '' }}" href="{{ url('/sitios') }}">SOCIEDADES</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('licencias.*') ? 'active' : '' }}" href="{{ url('/licencias') }}">Licencias</a>
                                </li>
                                @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                CERRAR SESIÓN
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-3 main-content">
        @yield('content')
    </main>
    @endguest

    <form id="frmBorrar" action="" method="post">
        @csrf
        @method('DELETE')
    </form>
    <form id="frmEditar" action="" method="post">
        @csrf
        @method('PUT')
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
</body>

</html>