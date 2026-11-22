<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return $user !== null;
    }

    public function view(User $user, Book $book): bool
    {
        return $user !== null;
    }

    public function create(User $user): bool
    {
        return $user !== null;
    }

    public function update(User $user, Book $book): bool
    {
        return $user !== null;
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->isAdmin();
    }
}
