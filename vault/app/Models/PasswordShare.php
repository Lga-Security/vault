<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PasswordEntry;
use App\Models\User;

class PasswordShare extends Model
{
    protected $fillable = [
    'password_entry_id',
    'shared_by_user_id',
    'shared_with_user_id',
    'permission'

    ];

    public function passwordEntry()
    {
        return $this->belongsTo(PasswordEntrie::class);
    }

    public function sharedBy()
    {
        return $this->belongsTo(User::class, 'shared_by_user_id');
    }

    public function sharedWith()
    {
        return $this->belongsTo(User::class, 'shared_with_user_id');
    }
}
