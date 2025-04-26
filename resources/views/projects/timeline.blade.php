<div class="card mb-3">
    <div class="card-body">
        <form method="POST" action="{{ route('seatpm.comments.store', $project->id) }}">
            @csrf
            <div class="mb-3">
                <label for="comment" class="form-label">New Comment</label>
                <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
    </div>
</div>
