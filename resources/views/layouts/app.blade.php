<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
<body>
<!--     <div id="app">
    
       
      
</div> -->
<header>
    
    @include('partials.navigation');
</header>
<main id="app" class="container mt-5">
    <div class="row">
        @yield('content')
    </div>
</main>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
