<div class="list-group">
    @forelse ($project->comments as $comment)
        <div class="list-group-item">
            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
            <p>{{ $comment->body }}</p>
        </div>
    @empty
        <div class="list-group-item text-center">
            No activity found yet.
        </div>
    @endforelse
</div>
