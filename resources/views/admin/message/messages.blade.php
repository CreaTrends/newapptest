
<div class="card mb-3">
  <div class="card-header bg-light d-flex justify-content-between">
    <h6><strong>{{ $message->user->name }} </strong>dijo :</h6>
    <small class="text-muted">Posted {{ $message->created_at->diffForHumans() }}</small>
  </div>
  <div class="card-body">
    <p class="card-text">{{ $message->body }}</p>
  </div>
</div>
