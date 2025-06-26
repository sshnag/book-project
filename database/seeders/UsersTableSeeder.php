<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // First check if admin already exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin',
                'password' => bcrypt('admin123'),
            ]
        );

        // Get or create admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin->assignRole($adminRole);

        // Create regular users only if they don't exist
        if (User::count() <= 1) {
            //     if only admin exists
            User::factory()->count(10)->create()->each(function ($user) {
                $userRole = Role::firstOrCreate(['name' => 'user']);
                $user->assignRole($userRole);
            });
        }
    }
}
