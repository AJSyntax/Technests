<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'portfolio_id',
        'title',
        'description',
        'github_url',
        'technologies',
    ];

    protected $casts = [
        'technologies' => 'json',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
