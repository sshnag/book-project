<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'manage books',
            'download books',
            'manage authors',
            'manage categories',
            'assign bookadmin role',
            'manage users',
            'assign roles'
        ];

        // Create permissions
        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name'       => $perm,
                'guard_name' => 'web',
            ]);
        }

        // Create roles
        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $bookadmin  = Role::firstOrCreate(['name' => 'bookadmin']);
        $user       = Role::firstOrCreate(['name' => 'user']);

        // Assign all permissions to superadmin
        $superadmin->syncPermissions(Permission::all());

        // Assign limited permissions to bookadmin
        $bookadmin->syncPermissions([
            'manage books',
            'download books',
            'manage authors',
            'manage categories',
        ]);

        // Assign basic permission to users
        $user->syncPermissions([
            'download books',
        ]);
    }
}
