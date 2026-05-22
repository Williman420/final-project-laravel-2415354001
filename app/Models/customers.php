<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $fillable = [
        'customer_id',
        'name',
        'email',
        'phone',
        'address',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
