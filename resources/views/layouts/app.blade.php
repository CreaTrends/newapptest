<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/icofont.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}?v=<?php echo md5(time());?>" rel="stylesheet">
</head>
<body class="h-100">
<!--     <div id="app">
    
       
      
</div> -->
<header>
    @includeWhen(Auth::check(), 'partials.navigation')
    
</header>
<main id="app" class="container h-100 mt-5 is-login">
    <div class="row h-100 justify-content-center align-items-center">
        @yield('content')
    </div>
</main>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
