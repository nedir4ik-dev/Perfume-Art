<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    use HasFactory;

    // Haýsy sütünlere maglumat ýazyp bolýandygyny kesgitleýäris
    protected $fillable = [
        'content',
        'icon',
        'color',
        'is_active',
        'order'
    ];

    // is_active sütüni boolean (true/false) hökmünde kabul eder ýaly
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
