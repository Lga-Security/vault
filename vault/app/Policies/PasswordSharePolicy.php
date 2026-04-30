<?php

namespace App\Policies;

use App\Models\PasswordShare;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PasswordSharePolicy
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
    public function view(User $user, PasswordShare $passwordShare): bool
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

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PasswordShare $passwordShare): bool
    {
        if($entry->vault->user_id == auth()->id())
            {return true;}
        
        return PasswordShare::where('password_entry_id', 'entry_id') -> where('shared_with_user_id', $entry->id)->where('permission', 'edit')
        ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PasswordShare $passwordShare): bool
    {
       

        return $entry->vault->user_id == auth()->id();
          
        
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PasswordShare $passwordShare): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PasswordShare $passwordShare): bool
    {
        return false;
    }
}
