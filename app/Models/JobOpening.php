<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOpening extends Model
{
    protected $fillable = [
        'title', 'location', 'type', 'description',
        'responsibilities', 'requirements', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'responsibilities' => 'array',
        'requirements' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
