<?php

namespace Database\Seeders;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
    ['email' => 'admin@gmail.com'],
    [
        'name' => 'Admin',
        'password' => bcrypt('admin123'),
    ]
);

        $role=Role::firstOrCreate( ['name'=> 'Admin'] );
        $permissions=Permission::pluck('name','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole($role->id);
    }
}
