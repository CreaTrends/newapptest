<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
        
        <link href="{{ asset('css/timepicki.css') }}?v=<?php echo md5(time());?>" rel="stylesheet">
    </head>
    <body>
        <!--     <div id="app">
            
            
            
        </div> -->
        
        <header>
            
        @auth
          @if(Auth::user()->hasRole(['superadministrator', 'teacher','administrator']))
            @include('partials.navigation-admin')
          @endif()
        @endauth
        </header>
        <main id="app" >
            @include('partials.pagetitle')

            <div class="container mt-0">
                @yield('content')
            </div>
        </main>
        <!-- Scripts -->
        
        <script src="{{ asset('js/app.js') }}"></script>
        
        <script src="{{ asset('js/tokenize2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/timepicki.js') }}?v=<?php echo md5(time());?>"></script>

        @yield('scripts')
        <script>
          function markAsRead(id){
            event.preventDefault();
            var id = this.id || null;
            console.log($(this));

          }
          </script>
    </body>
</html>