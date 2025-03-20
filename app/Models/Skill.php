<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'portfolio_id',
        'name',
        'category',
        'proficiency_level',
        'years_experience',
        'description',
    ];

    protected $casts = [
        'proficiency_level' => 'integer',
        'years_experience' => 'integer',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
