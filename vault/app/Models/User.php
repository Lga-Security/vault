<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'failed_login_attempts',
        'master_password_hash',
        'two_factor_enabled',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'master_password_hash',
        'two_factor_secret',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled'         => 'boolean',
            'two_factor_recovery_codes'  => 'array',
            'failed_login_attempts'      => 'integer',
        ];
    }

    public function vaults(): HasMany
    {
        return $this->hasMany(Vault::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function sharedPasswords(): HasMany
    {
        return $this->hasMany(PasswordShare::class, 'shared_by_user_id');
    }

    public function receivedPasswords(): HasMany
    {
        return $this->hasMany(PasswordShare::class, 'shared_with_user_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
}
