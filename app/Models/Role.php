<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'label'];

    // Bir rol köp rugsatlara eýe bolup biler
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    // Bir rolda köp ulanyjy bolup biler
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
