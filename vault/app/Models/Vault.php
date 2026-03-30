<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vault extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'icon',
        'color',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function passwordEntries(): HasMany
    {
        return $this->hasMany(PasswordEntry::class);
    }
}
