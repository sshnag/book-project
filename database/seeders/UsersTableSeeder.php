<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create or get the superadmin user
        $superadmin = User::firstOrCreate(
            ['email' => 'sadmin@gmail.com'],
            [
                'name'     => 'Super Admin',
                'password' => bcrypt('admin123'),
            ]
        );

        // Create roles if they don't exist
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $userRole       = Role::firstOrCreate(['name' => 'user']);

        // Assign only if not already assigned
        if (! $superadmin->hasRole('superadmin')) {
            $superadmin->assignRole($superadminRole);
        }

        // Create additional users if only superadmin exists
        if (User::count() <= 1) {
            User::factory()->count(10)->create()->each(function ($user) use ($userRole) {
                $user->assignRole($userRole);
            });
        }
    }
}
