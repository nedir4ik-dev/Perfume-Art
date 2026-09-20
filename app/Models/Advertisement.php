<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    // 1. Mass Assignment (Hansi sütünleriň doldurylyp bilinjekdigini aýdýarys)
    // Bu bolmasa Controller-de $request->all() ýa-da save() wagty "fillable" hatasyny berip biler.
    protected $fillable = [
        'title',
        'description',
        'link',
        'badge',
        'seconds',
        'is_active',
        'image'
    ];

    // 2. Casting (Bazadaky 0 ýa-da 1-i awtomatik true/false edýär)
    // Bu seniň Blade faýlyňda @if($ad->is_active) diýip ulanmagyňy aňsatlaşdyrýar.
    protected $casts = [
        'is_active' => 'boolean',
        'seconds' => 'integer',
    ];
}
