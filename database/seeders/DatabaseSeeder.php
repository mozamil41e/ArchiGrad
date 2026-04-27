<?php

namespace Database\Seeders;

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
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);


        $this->call([
            DepartmentSeeder::class,
            SupervisorSeeder::class,
            ProjectSeeder::class,
            StudentSeeder::class,
        ]);
    }
}
