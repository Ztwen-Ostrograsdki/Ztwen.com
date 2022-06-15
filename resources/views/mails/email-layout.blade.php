<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        @include("components.mycomponents.styles") {{-- chargement des styles --}}

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased" style="background-color: lightslategray;">
        @include('mails.email-header') {{-- chargement du header des emails --}}
        <div class="min-h-screen bg-gray-100" style="background-color: rgb(167, 193, 219);">
            <!-- Page Content -->
            <div class=" border mx-auto bg-success rounded w-75 p-3">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Mollitia eius nulla saepe harum commodi velit consequuntur facere temporibus, consectetur ad nostrum rerum. Adipisci ut molestiae aperiam tenetur cum quis facere?
            </div>
        </div>
        @include("mails.email-footer") {{-- chargement du footer des emails --}}
        @include("components.mycomponents.scripts") {{-- chargement des scripts js --}}
    </body>
</html>
