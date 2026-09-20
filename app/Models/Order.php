<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_token', // Cookie tanyşlygy üçin hökman gerek
        'customer_name',
        'customer_phone',
        'customer_email',
        'address',
        'total_price',
        'status',
        'items',
        'is_notified' // Real-time bildiriş üçin Controller-de bar eken
    ];
    
    protected $casts = [
        'items' => 'array',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
