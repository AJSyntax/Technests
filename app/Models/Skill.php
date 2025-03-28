<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'portfolio_id',
        'name',
        'category',
        'description',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
