<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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


        User::factory()->create([
            'name' => 'منسق المشاريع',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => Role::Admin,
        ]);

        User::factory()->create([
            'name' => 'مستخدم عادي',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => Role::User,
        ]);


        $this->call([
            DepartmentSeeder::class,
            SupervisorSeeder::class,
            ProjectSeeder::class,
            StudentSeeder::class,
        ]);
    }
}
