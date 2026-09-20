<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'price',
        'discount_percent',
        'discount_expires_at',
        'ml_size',
        'brand_id',
        'category_id',
        'description',
        'image',
        'stock_quantity',
        'is_active',
        'gender',
        'scent_notes'
    ];

    protected $appends = ['price_tmt', 'discounted_price'];

    protected $casts = [
        'discount_expires_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public function getPriceTmtAttribute()
    {
        $exchange_rate = 20;
        return $this->price * $exchange_rate;
    }

    public function inStock()
    {
        return $this->stock_quantity > 0;
    }

    public function isRunningLow()
    {
        return $this->stock_quantity <= 5 && $this->stock_quantity > 0;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getDiscountedPriceAttribute()
    {
        $hasDiscount = $this->discount_percent > 0;
        $notExpired = !$this->discount_expires_at || $this->discount_expires_at->isFuture();

        if ($hasDiscount && $notExpired) {
            return $this->price - ($this->price * $this->discount_percent / 100);
        }

        return $this->price;
    }

    public function hasActiveDiscount()
    {
        return $this->discount_percent > 0 && (!$this->discount_expires_at || $this->discount_expires_at->isFuture());
    }
}
