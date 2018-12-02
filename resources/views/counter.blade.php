@extends('layouts.adminDashboard')
@section('content')
<h1 id="abc">testing pusher {{Auth::id()}} </h1>
@endsection

@section('scripts')


<script>
    $( document ).ready(function() {
    window.Echo.private('App.User.'+{{Auth::id()}})
            .notification((notification) => {
                console.log(notification);
                $('#abc').html(notification);
            });
    });


    </script>
@endsection