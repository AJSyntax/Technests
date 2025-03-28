<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'template_id',
        'name',
        'is_premium',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
    ];

    protected $appends = [
        'profile_picture',
    ];

    public function getProfilePictureAttribute()
    {
        return $this->profile_picture_url ?? asset('images/default-avatar.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function personalInfo()
    {
        return $this->hasOne(PersonalInfo::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }
}
