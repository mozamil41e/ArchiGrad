<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'محمد أحمد إبراهيم عبدالله',
            'أحمد علي محمد الحسن',
            'خالد عبدالله إبراهيم الطيب',
            'عبدالله حسن أحمد عثمان',
            'علي محمد أحمد عبدالرحمن',

            'يوسف إبراهيم محمد عبدالله',
            'سعيد أحمد علي الحسن',
            'حسن علي إبراهيم الطيب',
            'طارق محمود أحمد عبدالرحيم',
            'رامي ناصر محمد عثمان',

            'مصطفى عمر إبراهيم عبدالله',
            'عمر خالد محمد الحسن',
            'إبراهيم يوسف أحمد الطيب',
            'عبدالرحمن أحمد علي محمد',
            'مازن علي حسن عبدالله',

            'سلمان خالد إبراهيم عثمان',
            'فهد محمد أحمد الحسن',
            'نواف عبدالله علي الطيب',
            'زياد أحمد محمد عبدالرحمن',
            'بدر علي إبراهيم عبدالله',

            'سارة محمد أحمد عبدالله',
            'فاطمة علي حسن الطيب',
            'مريم أحمد إبراهيم عثمان',
            'نورة خالد محمد الحسن',
            'هند عبدالله علي عبدالرحمن',

            'آية محمد أحمد الطيب',
            'دعاء علي حسن عبدالله',
            'سلمى أحمد إبراهيم عثمان',
            'رنا خالد محمد الحسن',
            'لينا عبدالله علي الطيب',

            'عائشة إبراهيم محمد عبدالله',
            'زينب أحمد علي الحسن',
            'هاجر محمد إبراهيم الطيب',
            'منى حسن أحمد عثمان',
            'رُبى علي محمد عبدالرحمن'
        ];



        $students = [];

        $counter = 1;

        for ($projectId = 1; $projectId <= 1000; $projectId++){

            // $project = \App\Models\Project::find($projectId);

            $deptId = rand(1, 3);

            for ($i = 0; $i < 3; $i++) {
                $students[] = [
                    'project_id' => $projectId,
                    'department_id' => $deptId, // 🔥 نفس القسم
                    'name' => $names[array_rand($names)] . ' ' . $counter,
                    'university_number' => '2024' . str_pad($counter, 7, '0', STR_PAD_LEFT),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $counter++;
            }
        }

        Student::insert($students);
    }
}

