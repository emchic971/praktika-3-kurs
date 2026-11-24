<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view catalog',
            'manage own orders',
            'manage orders',
            'edit orders',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $admin = Role::findOrCreate('admin', 'web');
        $admin->givePermissionTo(Permission::all());

        $manager = Role::findOrCreate('manager', 'web');
        $manager->givePermissionTo(['view catalog', 'manage orders']);

        $user = Role::findOrCreate('user', 'web');
        $user->givePermissionTo(['view catalog', 'manage own orders']);
    }
}