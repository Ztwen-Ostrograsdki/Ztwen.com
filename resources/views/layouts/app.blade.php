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
        @include("components.mycomponents.styles") {{-- chargement des styles --}}

        <!-- Scripts -->


    </head>
    <body class="font-sans antialiased" style="background-color: lightslategray;">
        @include('components.mycomponents.loader') {{-- chargement du loader --}}
        @livewire('header') {{-- chargement du header --}}
        {{-- chargement des modals --}}
        @livewire('registering-new-user')
        @livewire('forgot-password')
        @livewire('login-user') 
        @livewire('logout') 
        @livewire('user-profil-manager') 
        @livewire('following-system') 
        @livewire('create-category')
        @livewire('edit-category')
        @livewire('product-editor')
        @livewire('edit-product-data')
        @livewire('create-new-product')
        @livewire('manage-category-galery')
        @livewire('comment-manager')
        @livewire('display-my-notifications')
        @livewire('single-chat-inbox')
        @livewire('admin-master-authentication')
        @livewire('process-modal')
        {{-- chargement des modals --}}

        <div class=" bg-gray-100 border" style="background-color: rgb(167, 193, 219); min-height: 150vh !important;">
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
        @if(Route::currentRouteName() !== 'chat' && Route::currentRouteName() !== 'email-verification-notify' && Route::currentRouteName() !== 'force-email-verification-notify' && Route::currentRouteName() !== 'messenger')
            @livewire("footer") {{-- chargement du footer --}}
        @endif
        <script src="//{{Request::getHost()}}:6001/socket.io/socket.io.js" ></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script>
            window.User = { 
                id: {{optional(auth()->user())->id}},
            }
        </script>
        
        @include("components.mycomponents.scripts") {{-- chargement des scripts js --}}
    </body>
</html>
