<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'name_tm', 'name_ru', 'slug', 'logo_url', 'description', 'is_active'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getName()
    {
        $locale = app()->getLocale();

        if ($locale == 'tm' && $this->name_tm) {
            return $this->name_tm;
        }
        if ($locale == 'ru' && $this->name_ru) {
            return $this->name_ru;
        }

        return $this->name;
    }
}
