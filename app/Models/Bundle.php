<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'original_price',
        'bundle_price',
        'is_active',
        'sort_order',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'bundle_price'   => 'decimal:2',
        'is_active'      => 'boolean',
        'starts_at'      => 'date',
        'ends_at'        => 'date',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }

    public function getSavingsAttribute(): string
    {
        if ($this->original_price > 0 && $this->original_price > $this->bundle_price) {
            $saved = $this->original_price - $this->bundle_price;
            return number_format($saved, 2);
        }
        return '0.00';
    }

    public function getSavingsPercentAttribute(): int
    {
        if ($this->original_price > 0 && $this->original_price > $this->bundle_price) {
            return (int) round((($this->original_price - $this->bundle_price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function getIsCurrentlyActiveAttribute(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        $now = now()->startOfDay();

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->ends_at && $now->gt($this->ends_at)) {
            return false;
        }

        return true;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            });
    }
}
