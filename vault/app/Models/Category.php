<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable=[
    'name' , 'icon' , 'user_id' , 'is_default'
  ];
  protected $casts=[
        'is_default' => 'boolean',
    ];
    public function passwordEntries(): HasMany
    {
        return $this->HasMany(passwordEntries::class);
        }
}
