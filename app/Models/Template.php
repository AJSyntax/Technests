<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'thumbnail_url',
        'is_premium',
        'price',
        'html_template',
        'css_template',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }
}
