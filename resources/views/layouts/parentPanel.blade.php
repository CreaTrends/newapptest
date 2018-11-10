<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
       <title>My Website | @yield('title', 'Welcome')</title>
        <!-- Styles -->
        <link href="{{ asset('css/icofont.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}?v=<?php echo md5(time());?>" rel="stylesheet">
        <link href="{{ asset('css/tokenize2.min.css') }}?v=<?php echo md5(time());?>" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
        @yield('rawcss')
    </head>
    <body class="h-100">
        <!--     <div id="app">
            
            
            
        </div> -->
        @auth
          @if(Auth::user()->hasRole('parent'))
            @include('partials.navigation-parent')
            @include('partials.mobile-navigation-parent')
          @endif()
        @endauth
        <main id="app" class="is-login h-100">
            @yield('profile-header')
            <div class="container mt-0">
                <div class="row">
                    
                    
                    
                    <div class="col-md-12">
                            @yield('content')
                    </div>
                </div>
            </div>
        </main>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}?v=<?php echo md5(time());?>"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="{{ asset('js/tokenize2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
        @yield('scripts')
        
    </body>
</html>