<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Bookpolicy
{
    /**
     * Determine whether the user can view any models.
     *
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Book $book): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     * both superadmin and bookadmin can create
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole('superadmin','bookadmin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Book $book): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * Only superadmin can delete
     */
    public function delete(User $user, Book $book): bool
    {
        return $user->hasRole('superadmin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Book $book): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Book $book): bool
    {
        return false;
    }
}
