<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'wp_term_id',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
