<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PasswordEntry;

class PasswordEntryPolicy
{
    public function view(User $user, PasswordEntry $entry): bool
    {
        // The entry's vault must belong to this user
        return $entry->vault->user_id === $user->id;
    }

    public function update(User $user, PasswordEntry $entry): bool
    {
        return $entry->vault->user_id === $user->id;
    }

    public function delete(User $user, PasswordEntry $entry): bool
    {
        return $entry->vault->user_id === $user->id;
    }
}