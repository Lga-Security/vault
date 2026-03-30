<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordEntry extends Model
{
    protected $fillable = [
        'vault_id',
        'category_id',
        'site_name',
        'username',
        'password',
        'notes',
    ];

    public function vault()
    {
        return $this->belongsTo(Vault::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function shares()
    {
        return $this->hasMany(PasswordShare::class);
    }
}
