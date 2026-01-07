<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Department::factory(5)->create();
         $departments = [
            ['name' => 'تقنية المعلومات'],
            ['name' => 'علوم الحاسوب'],
            ['name' => 'نظم معلومات'],
        ];

        \App\Models\Department::insert($departments);
    }
}
