<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name',
        'thumbnail_path',
        'description',
        'is_premium',
        'price',
        'preview_url',
        'features',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'features' => 'array',
        'price' => 'decimal:2',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }
}
