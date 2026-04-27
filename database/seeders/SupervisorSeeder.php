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
            ['name' => 'أحمد محمد', 'department_id' => 1],
            ['name' => 'سارة علي', 'department_id' => 2],
            ['name' => 'خالد عبدالله', 'department_id' => 3],
            ['name' => 'نورة حسن', 'department_id' => 1],

            ['name' => 'محمد إبراهيم', 'department_id' => 2],
            ['name' => 'فاطمة يوسف', 'department_id' => 3],
            ['name' => 'علي حسن', 'department_id' => 1],
            ['name' => 'مريم خالد', 'department_id' => 2],
            ['name' => 'عبدالله أحمد', 'department_id' => 3],
            ['name' => 'هند صالح', 'department_id' => 1],

            ['name' => 'يوسف عمر', 'department_id' => 2],
            ['name' => 'سلمى محمود', 'department_id' => 3],
            ['name' => 'طارق عبدالكريم', 'department_id' => 1],
            ['name' => 'لينا سعد', 'department_id' => 2],
            ['name' => 'رامي ناصر', 'department_id' => 3],
            ['name' => 'دعاء عادل', 'department_id' => 1],

            ['name' => 'حسن علي', 'department_id' => 2],
            ['name' => 'آية محمد', 'department_id' => 3],
            ['name' => 'محمود خالد', 'department_id' => 1],
            ['name' => 'نور إبراهيم', 'department_id' => 2],
            ['name' => 'سعيد أحمد', 'department_id' => 3],
            ['name' => 'رنا يوسف', 'department_id' => 1],
        ];

        \App\Models\Supervisor::insert($supervisors);
    }
}
