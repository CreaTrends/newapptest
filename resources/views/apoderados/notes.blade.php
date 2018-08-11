@extends('layouts.adminDashboard')
@section('content')

<ul>
    @foreach($notes as $month => $items)
    <li>
        {{$month}}
    </li>
    
</ul>
@endforeach
@foreach($notes as $month => $items)
<div class="col-md-12 order-md-2 mb-4">
    <h4 class="d-flex justify-content-between align-items-center mb-3">
    <span class="text-muted">{{$month}}</span>
    </h4>
    <ul class="list-group mb-3">
        @foreach($items as $item)
        <li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
                <h6 class="my-0">{{$item->subject}}</h6>
                <small class="text-muted">{!! $item->body !!}</small>
            </div>
            <span class="text-muted">{{$item->created_at->diffForHumans()}}</span>
        </li>
        @endforeach
    </ul>
</div>
@endforeach
<div class="col-md-8 order-md-2 mb-4">
@foreach($notes as $month => $items)
<div class="card mb-3">
  <div class="card-header bg-light">
    {{$month}}
  </div>
  <ul class="list-group list-group-flush">
    @foreach($items as $item)
    <li class="list-group-item"><h5 class="card-title">{{$item->subject}}</h5> {!! $item->body !!}</li>
    @endforeach
  </ul>
</div>
@endforeach
</div>
@endsection
