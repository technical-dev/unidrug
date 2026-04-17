<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service_type',
        'message',
        'status',
    ];
}
