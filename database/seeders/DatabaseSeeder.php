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
        // 1. Ilki bilen Rollary döredeliň
        $adminRole = Role::create(['name' => 'Admin', 'label' => 'Baş Administrator']);
        $moderatorRole = Role::create(['name' => 'Moderator', 'label' => 'Moderator']);

        // 2. Permission-lary döretmek
        $p1 = Permission::create(['name' => 'manage-products', 'label' => 'Harytlary dolandyrmak']);
        $p2 = Permission::create(['name' => 'view-dashboard', 'label' => 'Dashboardy görmek']);
        $p3 = Permission::create(['name' => 'manage-users', 'label' => 'Ulanyjylary dolandyrmak']);

        // 3. Rugsatlary Admin rolyna birikdirmek
        $adminRole->permissions()->sync([$p1->id, $p2->id, $p3->id]);

        // 4. Admin ulanyjysyny döretmek we oňa ROL bermek
        User::create([
            'username' => 'admin',
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'role_id' => $adminRole->id, // MÖHÜM: Rol ID-sini hökman ýazmaly
        ]);

        // 5. Beýleki seeder-leri çagyrmak
        $this->call([
            BrandSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
