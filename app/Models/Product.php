<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'sku',
        'price',
        'sale_price',
        'product_type',
        'stock_status',
        'stock_quantity',
        'weight',
        'featured_image',
        'category_id',
        'status',
        'is_featured',
        'wp_post_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getDisplayPriceAttribute(): string
    {
        if ($this->product_type === 'variable') {
            $prices = $this->variations->pluck('price')->filter();

            if ($prices->isEmpty()) {
                return number_format((float) $this->price, 2);
            }

            $min = $prices->min();
            $max = $prices->max();

            return $min == $max
                ? number_format((float) $min, 2)
                : number_format((float) $min, 2) . ' - ' . number_format((float) $max, 2);
        }

        return number_format((float) ($this->sale_price ?? $this->price), 2);
    }
}
