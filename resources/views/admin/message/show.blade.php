@extends('layouts.adminDashboard')
@section('content')
<div class="row">
<div class="col-md-3">

    asfasdf
</div>
<div class="col-md-9 my-3 p-3">
    
    <h3 class="border-bottom border-gray pb-2 mb-0">{{ $thread->subject }}</h3>
    <div id="thread_{{ $thread->id }}">
        <ul class="list-unstyled">
            @each('admin.message.messages', $thread->messages, 'message')
        </ul>
    </div>
    @include('admin.message.form-message')
</div>
</div>
@stop