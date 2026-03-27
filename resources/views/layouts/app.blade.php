<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>{{ config('app.name', 'Driveloop') }}</title>
        
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        <!-- Icon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/publicacion/pubVeh.css', 'resources/js/app.js'])
</head>
    
    <body class="antialiased">
        <div class="min-h-screen img-background">
            <div class="mx-4 sm:mx-16 sm:px-6 lg:px-8 min-w-60">
                <div class="py-2">
                    <div class="p-2">
                        @include('layouts.navigation')
                    </div>
                </div>
                <!-- Page Heading -->
                <!-- @isset($header)
                    <header class="shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset -->
                <!-- Page Content -->
                <main>
                    <div class="py-1">
                        <div class="sm:rounded-lg">
                            <div class="p-2">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>  
        
        <!-- Script para funcionamiento del carrusel -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    </body>
</html>
