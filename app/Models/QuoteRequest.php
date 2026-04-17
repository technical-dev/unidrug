<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'city',
        'address',
        'building',
        'floor',
        'message',
        'payment_method',
        'delivery_notes',
        'items',
        'estimated_total',
        'status',
        'admin_notes',
        'tracking_token',
    ];

    protected $casts = [
        'items' => 'array',
        'estimated_total' => 'decimal:2',
    ];
}
