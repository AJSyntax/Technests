<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'portfolio_id',
        'name',
        'description',
        'github_url',
        'live_url',
        'image_path',
        'technologies_used',
        'start_date',
        'end_date',
        'is_featured',
        'display_order',
    ];

    protected $casts = [
        'technologies_used' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'display_order' => 'integer',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
