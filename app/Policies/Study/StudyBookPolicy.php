<?php

namespace App\Policies\Study;

use App\Models\Study\StudyBook;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class  StudyBookPolicy
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
    public function view(User $user, StudyBook $studyBook): bool
    {
        return $user->id === $studyBook->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StudyBook $studyBook): bool
    {
        return $user->id === $studyBook->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StudyBook $studyBook): bool
    {
        return $user->id === $studyBook->user_id;
    }

    public function download(User $user, StudyBook $studyBook): bool
    {
        return $user->id === $studyBook->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StudyBook $studyBook): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StudyBook $studyBook): bool
    {
        return false;
    }
}
