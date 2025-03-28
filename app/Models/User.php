<?php

namespace App\Models;

use App\Notifications\LogVerificationNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_banned',
        'github_username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'is_admin' => 'boolean',
            'is_banned' => 'boolean',
        ];
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new LogVerificationNotification);
    }

    /**
     * Get the portfolios for the user.
     */
    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }

    public function hasPermission($permission)
    {
        return $this->roles->contains(function ($role) use ($permission) {
            return $role->hasPermission($permission);
        });
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::findBySlug($role);
        }
        return $this->roles()->sync($role, false);
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::findBySlug($role);
        }
        return $this->roles()->detach($role);
    }
}
