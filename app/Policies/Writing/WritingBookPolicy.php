<?php

namespace App\Policies\Writing;

use App\Models\User;
use App\Models\Writing\WritingBook;
use Illuminate\Auth\Access\Response;

class WritingBookPolicy
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
    public function view(User $user, WritingBook $writingBook): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }


    public function edit(User $user, WritingBook $writingBook)
{
    return $user->id === $writingBook->user_id;
}
  
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WritingBook $writingBook): bool
    {
        return $user->id === $writingBook->user_id;
    }

    public function download(User $user, WritingBook $writingBook): bool
    {
        return $user->id === $writingBook->user_id;
    }   

    /** 
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WritingBook $writingBook): bool
    {
        return $user->id === $writingBook->user_id;    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WritingBook $writingBook): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WritingBook $writingBook): bool
    {
        return false;
    }
}
