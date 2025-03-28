<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->first();
    }

    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->contains('slug', $permission);
        }
        return !! $permission->intersect($this->permissions)->count();
    }

    public function assignPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::findBySlug($permission);
        }
        return $this->permissions()->sync($permission, false);
    }

    public function removePermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::findBySlug($permission);
        }
        return $this->permissions()->detach($permission);
    }
} 