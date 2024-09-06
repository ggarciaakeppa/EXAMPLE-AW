<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('meta_description', config('app.name'))">
        <meta name="author" content="@yield('meta_author', config('app.name'))">
        
        <!-- Favicon -->
        <!--<link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">-->
        <link rel="shortcut icon" href="{{ asset('/img/logos/logo.png') }}" type="image/x-icon"/>
        
        <!-- Map CSS -->
        <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" />
        @php $showarray = Config::get('theme.var'); @endphp
        
        <!-- Libs CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/libs.bundle.css') }}" />

        <style>
            [x-cloak] { display: none !important; }
        </style>
        
        <link rel="stylesheet" href="{{ asset('/assets/custom/modal/modal.css') }}">

        <!-- Theme CSS -->
        @if($showarray['demoMode'])
        <link rel="stylesheet" href="{{ asset('assets/css/theme.bundle.css') }}" id="stylesheetLight" />
        <link rel="stylesheet" href="{{ asset('assets/css/theme-dark.bundle.css') }}" id="stylesheetDark" />

        <!-- <style>body { display: none; }</style> -->
        @else
        @if($showarray['colorScheme'] == 'light')
        <link rel="stylesheet" href="{{ asset('assets/css/theme.bundle.css') }}" />
        @elseif($showarray['colorScheme'] == 'dark')
        <link rel="stylesheet" href="{{ asset('assets/css/theme-dark.bundle.css') }}" />
        @endif
        @endif

        <!-- JETSTREAM -->

        <!-- Styles -->
        
        @stack('css')

        <!-- Styles -->
        @livewireStyles

        <!-- Scripts -->
        <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
        @vite(['resources/js/app.js'])

        <!-- JETSTREAM -->

        <!-- Title -->
        <title>{{ config('app.name', 'Akeppa') }}</title>
    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <!-- OFFCANVAS -->

        <!-- NAVIGATION -->
        <div class="min-h-screen">
            @livewire('navigation-menu')

            <div class="main-content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <!-- Page Heading -->
                        @if (isset($header))
                            {{ $header }}
                        @endif
                        <!-- Content -->
                        {{ $slot }}
                    </div>
                </div>
            </div>

        </div>

        <!-- MODALS -->
        @stack('modals')

        <!-- Map JS -->
        <script src='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.js'></script>

        <script src="{{ asset('/assets/custom/jquery/jquery-3.6.0.min.js') }}" crossorigin="anonymous"></script>

        @livewireScripts
        @stack('js')
        <!-- Vendor JS -->
        <script src="{{ asset('assets/js/vendor.bundle.js') }}"></script>

        <!-- Theme JS -->
        <script src="{{ asset('assets/js/theme.bundle.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    </body>
</html>
