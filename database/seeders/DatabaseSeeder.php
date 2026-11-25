<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Permission;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'Admin', 'label' => 'Baş Administrator']);
        $moderatorRole = Role::create(['name' => 'Moderator', 'label' => 'Moderator']);

        $p1 = Permission::create(['name' => 'manage-products', 'label' => 'Harytlary dolandyrmak']);
        $p2 = Permission::create(['name' => 'view-dashboard', 'label' => 'Dashboardy görmek']);
        $p3 = Permission::create(['name' => 'manage-users', 'label' => 'Ulanyjylary dolandyrmak']);

        $adminRole->permissions()->sync([$p1->id, $p2->id, $p3->id]);


        User::create([
            'name'     => 'Admin',
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'role_id'  => 1
        ]);

        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
