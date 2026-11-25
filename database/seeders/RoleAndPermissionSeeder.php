<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            ['name' => 'view-dashboard', 'label' => 'Dashboardy görmek'],
            ['name' => 'manage-roles', 'label' => 'Rollary dolandyrmak'],
            ['name' => 'manage-users', 'label' => 'Ulanyjylary dolandyrmak'],
            ['name' => 'manage-products', 'label' => 'Harytlary dolandyrmak'],
            ['name' => 'manage-categories', 'label' => 'Kategoriýalary dolandyrmak'],
            ['name' => 'manage-brands', 'label' => 'Brandlary dolandyrmak'],
            ['name' => 'manage-orders', 'label' => 'Sargytlary dolandyrmak'],
            ['name' => 'manage-ads', 'label' => 'Mahabatlary dolandyrmak'],
            ['name' => 'manage-tickers', 'label' => 'Tickerlary dolandyrmak'],
            ['name' => 'manage-activities', 'label' => 'Loglary görmek'],
            ['name' => 'manage-backups', 'label' => 'Backuplary dolandyrmak'],
            ['name' => 'manage-settings', 'label' => 'Sazlamalary dolandyrmak'],
        ];

        foreach ($permissions as $p) {
            Permission::updateOrCreate(['name' => $p['name']], $p);
        }

        $adminRole = Role::updateOrCreate(['name' => 'admin'], ['label' => 'Administrator']);
        $adminRole->permissions()->sync(Permission::pluck('id'));

        $moderatorRole = Role::updateOrCreate(['name' => 'moderator'], ['label' => 'Moderator']);

        $modPermissions = Permission::whereIn('name', [
            'view-dashboard',
            'manage-products',
            'manage-orders'
        ])->pluck('id');
        $moderatorRole->permissions()->sync($modPermissions);

        $adminUser = User::where('username', 'nedir')->first();
        if ($adminUser) {
            $adminUser->update(['role_id' => $adminRole->id, 'is_admin' => 1]);
        }

        $modUser = User::where('username', 'moderator')->first();
        if ($modUser) {
            $modUser->update(['role_id' => $moderatorRole->id, 'is_admin' => 1]);
        }

        $this->command->info("Rollar we rugsatlar üstünlikli täzelendi!");
    }
}
