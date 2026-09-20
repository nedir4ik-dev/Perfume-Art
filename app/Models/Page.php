<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'meta_title',
        'meta_description',
        'is_active'
    ];

    /**
     * Boot funksiýasy arkaly sahypa goşulanda titla görä automatic slug ýasarys.
     * Mysal üçin: "Biz barada" diýip ýazsaňyz -> "biz-barada" edip URL taýýarlar.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
        });
    }
}
