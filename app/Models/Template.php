<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'preview_url',
        'price',
        'is_premium',
        'css_template',
        'js_template',
        'html_template',
        'features',
        'category',
        'tags',
        'version',
        'status'
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'price' => 'decimal:2',
        'features' => 'array',
        'tags' => 'array',
    ];

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? Storage::url($this->thumbnail) : null;
    }

    public function getPreviewUrlAttribute()
    {
        return $this->preview_url ? Storage::url($this->preview_url) : null;
    }
}
