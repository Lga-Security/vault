<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vault extends Model
{
    protected $fillable=[
    'user_id' , 'name' , 'description' , 'icon' , 'color'];
    
    public function user(): BelongsTo
 {
    return $this->belongsTo(User::class);
    }


public function passwordEntries(): HasMany
{
    return $this->hasMany(PasswordEntry::class);
    }
    
};


