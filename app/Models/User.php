<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'role_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists');
    }

    public function hasPermission($permissionName)
    {
        // Eger ulanyjynyň roly ýok bolsa göni false
        if (!$this->relationLoaded('role')) {
            $this->load('role.permissions');
        }

        if (!$this->role) {
            return false;
        }

        if (str_contains(strtolower($this->role->name), 'admin')) {
            return true;
        }

        return $this->role->permissions ? $this->role->permissions->contains('name', $permissionName) : false;
    }

    protected static function booted()
    {
        static::saving(function ($user) {
            // Query geçirip loop döretmezlik üçin göni role_id barlayarys
            if (!empty($user->role_id)) {
                // Mysal üçin 1 = Super Admin, 2 = Admin (Siziň bazaňyzdaky ID-ler)
                // Ya-da role_id bar bolsa awtomatiki checking:
                $adminRoleIds = \App\Models\Role::whereIn('name', ['admin', 'super-admin', 'moderator'])->pluck('id')->toArray();
                $user->is_admin = in_array($user->role_id, $adminRoleIds) ? 1 : 0;
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
