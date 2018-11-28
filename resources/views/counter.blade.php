@extends('layouts.adminDashboard')
@section('content')
<h1>testing pusher {{Auth::id()}} </h1>
@endsection

@section('scripts')


<script>
    $( document ).ready(function() {
    window.Echo.private('App.User.'+{{Auth::id()}})
            .notification((notification) => {
                alert(notification.message);
            });
    });


    </script>
@endsection