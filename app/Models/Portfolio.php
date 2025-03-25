<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'template_id',
        'personal_info',
        'skills',
        'experience',
        'projects',
    ];

    protected $casts = [
        'personal_info' => 'array',
        'skills' => 'array',
        'experience' => 'array',
        'projects' => 'array',
        'is_public' => 'boolean',
    ];

    protected $appends = [
        'profile_picture',
    ];

    public function getProfilePictureAttribute()
    {
        return $this->profile_picture_url ?? asset('images/default-avatar.png');
    }

    public function setPersonalInfoAttribute($value)
    {
        $this->attributes['personal_info'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setSkillsAttribute($value)
    {
        $this->attributes['skills'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setExperienceAttribute($value)
    {
        $this->attributes['experience'] = is_array($value) ? json_encode($value) : $value;
    }

    public function setProjectsAttribute($value)
    {
        $this->attributes['projects'] = is_array($value) ? json_encode($value) : $value;
    }

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
