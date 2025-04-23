<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Jeton CSRF pour sécuriser les formulaires -->

        <title>{{ config('app.name', 'Laravel') }}</title> <!-- Titre de la page (issu du fichier .env ou fallback) -->

        <!-- Chargement des polices via Bunny Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Liens vers les fichiers CSS/JS compilés avec Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Inclusion de la barre de navigation -->
            @include('layouts.navigation')
            
            
            <!-- Zone d'en-tête conditionnelle -->
            @isset($header)
                @if(trim($header ?? '') !== '')
                 <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                          {{ $header }} <!-- Contenu de l'en-tête injecté depuis les vues -->
                    </div>
                </header>
                @endif  
            @endisset

            <!-- Contenu principal de la page injecté dans le layout via {{ $slot }} -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
