<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Supervisor::factory(20)->create();
         $supervisors = [
            [
                'name' => 'أحمد محمد',

                'department_id' => 1,
            ],
            [
                'name' => 'سارة علي',

                'department_id' => 2,
            ],
            [
                'name' => 'خالد عبدالله',

                'department_id' => 3,
            ],
            [
                'name' => 'نورة حسن',

                'department_id' => 1,
            ],
        ];

        \App\Models\Supervisor::insert($supervisors);
    }
}
