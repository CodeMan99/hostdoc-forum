<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    private function is_created_by(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    private function is_recent(Comment $comment): bool
    {
        return $comment->created_at->isAfter(now()->subHour());
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $this->is_created_by($user, $comment);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $this->is_created_by($user, $comment) && $this->is_recent($comment);
    }
}
