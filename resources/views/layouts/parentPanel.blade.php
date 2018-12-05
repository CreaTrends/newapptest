<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" style="position: relative; min-height: 100%">
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
        
        @yield('rawcss')
    </head>
    <body style="margin-bottom: 130px">
        <!--     <div id="app">
            
            
            
        </div> -->
        @auth
          @if(Auth::user()->hasRole('parent'))
            @include('partials.navigation-parent')
            @include('partials.mobile-navigation-parent')
          @endif()
        @endauth
        <main id="app" class="pb-5">
            @yield('profile-header')
            <div class="container mt-0">
                <div class="row">
                    
                    
                    
                    <div class="col-md-12">
                            @yield('content')
                    </div>
                </div>
            </div>
        </main>
        <footer class="footer">
            <div class="container col-12 col-md-8  ">
                <div class="d-flex justify-content-center align-self-center">
                    <div class="text-muted align-self-center">
                        Jardín Anatolia 2018-2019 . Powered by <a href="#">Creatrends.cl</a>
                    </div>
                </div>
                
            </div>
        </footer>
        <!-- Scripts -->

        <script src="{{ asset('js/app.js') }}?v=<?php echo md5(time());?>"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="{{ asset('js/tokenize2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.6/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
        @yield('scripts')
        <script>
            $('#markAllAsRead').on('click',function(){
                event.stopPropagation();
                $url = $(this).data('url');
                notifications.markAllAsRead($url);

            });
            $('a[data-action="notification-hide"]').on('click',function(){
                event.stopPropagation();
                $url = $(this).data('url');
                $uid = $(this).data('user');
                $nid = $(this).data('alert-id');
                var data = [];
                data.push($nid);
                data.push($uid);
                notifications.deleteNotification(data,$url);

            });
            </script>
    </body>
</html>