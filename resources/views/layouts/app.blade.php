<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <title>Sixteen Clothing HTML Template</title>
        @include("components.mycomponents.styles") {{-- chargement des styles --}}

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        @include('components.mycomponents.loader') {{-- chargement du loader --}}
        @livewire('header') {{-- chargement du header --}}
        {{-- chargement des modals --}}
        @livewire('registering-new-user')
        @livewire('forgot-password')
        @livewire('login-user') 
        @livewire('logout') 
        @livewire('user-profil-manager') 
        @livewire('following-system') 
        @livewire('product-profil')
        @livewire('product-editor')
        {{-- chargement des modals --}}

        <div class="min-h-screen bg-gray-100" style="background-color: lightslategray;">
            <!-- Page Content -->
            <div class="">
                @if (isset($slot))
                    <div class="">
                        {{ $slot }}
                    </div>
                @else
                    {{abort(404, "La Page que vous rechercher n'existe pas!!!")}}
                @endif
                
            </div>
        </div>
        @include('sweetalert::alert')
        @if(Route::currentRouteName() !== 'chat' && Route::currentRouteName() !== 'messenger' && Route::currentRouteName() !== 'product-profil')
            @include("components.mycomponents.footer") {{-- chargement du footer --}}
        @endif
        @include("components.mycomponents.scripts") {{-- chargement des scripts js --}}


    
    </body>
</html>
