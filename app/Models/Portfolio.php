<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'name',
        'title',
        'bio',
        'contact_email',
        'phone',
        'location',
        'website',
        'github_username',
        'linkedin_url',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class)->orderBy('order');
    }

    public function education()
    {
        return $this->hasMany(Education::class)->orderBy('order');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class)->orderBy('order');
    }
}
