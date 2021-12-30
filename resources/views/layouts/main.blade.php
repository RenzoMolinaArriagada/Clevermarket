<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/5adb05eff4.js" crossorigin="anonymous"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <!-- Personalizacion -->
        <style type="text/css">
            @isset($personalizacion)
            @font-face {
                font-family: {{$personalizacion->fuente}};
                src:    url('{{ asset('fonts/ufohunter/ufohunter.ttf') }}') format('truetype'),
                        url('{{ asset('fonts/ufohunter/ufohunter.woff') }}') format('woff');
            }

            .btn-precio-fg{
                background-color: {{$personalizacion->color_botones_back}} !important;
                color: {{$personalizacion->color_botones_front}} !important;
            }
            @else
               @font-face {
                font-family: "UfoHunter";
                src:    url('{{ asset('fonts/ufohunter/ufohunter.ttf') }}') format('truetype'),
                        url('{{ asset('fonts/ufohunter/ufohunter.woff') }}') format('woff');
                }

                .btn-precio-fg{
                    background-color: #0c1429 !important;
                    color: white !important;    
                } 
            }
            @endisset
        </style>
    </head>
    <body class="body-forcegamer d-flex flex-column h-100">
        @include('layouts.navegacion')    
        @yield('contenido')
        @include('layouts.footer')
    </body>
    @yield('ajax')
</html>
