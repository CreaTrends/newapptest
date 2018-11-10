@extends('layouts.adminDashboard')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <a href="{{route('admin.messages')}}" class="my-2 btn custom-btn btn-link">Volver </a>
        <ul class="list-unstyled">
            @foreach($thread->messages as $message)
                <li class="media p-2 pt-3 border-bottom mb-0" id="thread_list_{{ $message->id }}">
                    <img class="mr-3" src="https://ui-avatars.com/api/?background=49bfbf&color=fff&name={{$message->user->name}}" alt="Generic placeholder image" width="48">
                    <div class="media-body">
                        <h6 class="mt-0 mb-1">
                        <strong>{{ $message->user->name }}</strong> dijo :
                        <div class="text-muted">
                            <small> {{ $message->created_at->diffForHumans() }}</small>
                        </div>
                        </h6>
                        <p style="line-height: .85rem;">
                            <small style="font-weight: 600;">
                            {{ $message->body }}
                            </small>
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div>
            <form action="{{ route('admin.inbox.update', $thread->id) }}" method="post">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                
                <!-- Message Form Input -->
                <div class="form-group">
                    <textarea name="message" class="form-control" rows="3">{{ old('message') }}</textarea>
                </div>
                 <!-- @if($users->count() > 0)
                         <div class="checkbox">
                             @foreach($users as $user)
                                 <label title="{{ $user->name }}">
                    <input type="checkbox" name="recipients[]" value="{{ $user->id }}">{{ $user->name }}
                                 </label>
                             @endforeach
                         </div>
                     @endif -->
                <!-- Submit Form Input -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary custom-btn is-lightblue">Enviar Mensaje</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
  $('.list-unstyled').slimscroll({
        height: '180px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });
</script> 
@endsection