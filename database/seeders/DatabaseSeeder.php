<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('departments')->truncate();
        DB::table('supervisors')->truncate();
        DB::table('projects')->truncate();
        DB::table('students')->truncate();
        DB::table('users')->truncate();

 $this->call([
            RolesAndPermissionsSeeder::class,
            AdminSeeder::class,
            DepartmentSeeder::class,
            SupervisorSeeder::class,
            ProjectSeeder::class,
            StudentSeeder::class,
        ]);

        $user = User::firstOrCreate(
            [
                'email' => 'user@example.com',
            ],
            [
                'name' => 'system user',
                'password' => Hash::make('password'),
            ]
        );

        $user->assignRole('user1');


    }
}
