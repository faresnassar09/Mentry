<?php

namespace App\Policies\Writing;

use App\Models\User;
use App\Models\Writing\WritingBook;
use App\Models\Writing\WritingNote;

class WritingNotePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WritingNote $writingNote): bool
    {
        return $user->id === $writingNote->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function store(User $user,WritingBook $writingBook): bool
    {
return true;    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WritingNote $writingNote): bool
    {
        return  $user->id === $writingNote->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WritingNote $writingNote): bool
    {
        return $user->id === $writingNote->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WritingNote $writingNote): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WritingNote $writingNote): bool
    {
        return false;
    }
}
