<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    protected $table = 'personal_info';

    protected $fillable = [
        'portfolio_id',
        'title',
        'bio',
        'contact_info',
    ];

    protected $casts = [
        'contact_info' => 'json',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
} 