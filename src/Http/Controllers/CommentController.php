<?php

namespace CapsuleCmdr\SeATPM\Http\Controllers;

use CapsuleCmdr\SeATPM\Models\Comment;
use CapsuleCmdr\SeATPM\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Store a new comment for a task.
     */
    public function store(Request $request, Task $task)
    {
        $this->authorize('view', $task->project);

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $task->comments()->create([
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        return redirect()->back()->with('success', 'Comment added.');
    }

    /**
     * Update an existing comment.
     */
    public function update(Request $request, Comment $comment)
    {
        if (Gate::denies('update-comment', $comment)) {
            abort(403, 'You are not authorized to update this comment.');
        }

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $comment->update([
            'message' => $validated['message'],
        ]);

        return redirect()->back()->with('success', 'Comment updated.');
    }

    /**
     * Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        if (Gate::denies('delete-comment', $comment)) {
            abort(403, 'You are not authorized to delete this comment.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted.');
    }
}
