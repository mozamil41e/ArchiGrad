<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Project::factory(1000)->create();

        $projects = [
    [
        'department_id' => 1,
        'supervisor_id' => 1,
        'title' => 'نظام إدارة المخازن',
        'description' => 'نظام إلكتروني لإدارة وتتبع المخزون وتنظيم العمليات داخل المخزن بدقة.',
        'is_archiv' => false,
        'year' => 2024,
        'submission_deadline' => '2024-06-15',
        'file_path' => null,
    ],
    [
        'department_id' => 2,
        'supervisor_id' => 2,
        'title' => 'نظام إدارة المشاريع',
        'description' => 'نظام لإدارة المشاريع ومتابعة المهام والجداول الزمنية.',
        'is_archiv' => true,
        'year' => 2023,
        'submission_deadline' => '2023-05-20',
        'file_path' => null,
    ],
    [
        'department_id' => 3,
        'supervisor_id' => 3,
        'title' => 'نظام الموارد البشرية',
        'description' => 'نظام لإدارة بيانات الموظفين والإجازات والحضور والانصراف.',
        'is_archiv' => true,
        'year' => 2022,
        'submission_deadline' => '2022-06-10',
        'file_path' => null,
    ],
    [
        'department_id' => 1,
        'supervisor_id' => 4,
        'title' => 'نظام الحجز الإلكتروني',
        'description' => 'تطبيق لحجز الخدمات والمواعيد عبر الإنترنت بسهولة.',
        'is_archiv' => false,
        'year' => 2024,
        'submission_deadline' => '2024-06-10',
        'file_path' => null,
    ],
    [
        'department_id' => 2,
        'supervisor_id' => 5,
        'title' => 'تطبيق توصيل الطلبات',
        'description' => 'نظام لإدارة طلبات التوصيل وتتبع حالة الطلبات.',
        'is_archiv' => true,
        'year' => 2023,
        'submission_deadline' => '2023-06-01',
        'file_path' => null,
    ],
    [
        'department_id' => 3,
        'supervisor_id' => 6,
        'title' => 'نظام التعليم الإلكتروني',
        'description' => 'منصة تعليم عن بعد لإدارة الدورات والمحتوى التعليمي.',
        'is_archiv' => false,
        'year' => 2024,
        'submission_deadline' => '2024-06-20',
        'file_path' => null,
    ],
    [
        'department_id' => 1,
        'supervisor_id' => 7,
        'title' => 'نظام إدارة العيادات',
        'description' => 'نظام لإدارة مواعيد وعمليات العيادات الطبية.',
        'is_archiv' => true,
        'year' => 2022,
        'submission_deadline' => '2022-05-30',
        'file_path' => null,
    ],
    [
        'department_id' => 2,
        'supervisor_id' => 8,
        'title' => 'نظام إدارة المكتبات',
        'description' => 'نظام لإدارة الكتب والإعارات وتتبع أعضاء المكتبة.',
        'is_archiv' => true,
        'year' => 2023,
        'submission_deadline' => '2023-06-05',
        'file_path' => null,
    ],
    [
        'department_id' => 3,
        'supervisor_id' => 9,
        'title' => 'نظام نقاط البيع POS',
        'description' => 'نظام نقاط بيع لإدارة المبيعات والفواتير والتقارير.',
        'is_archiv' => false,
        'year' => 2024,
        'submission_deadline' => '2024-06-12',
        'file_path' => null,
    ],
    [
        'department_id' => 1,
        'supervisor_id' => 10,
        'title' => 'نظام إدارة المدارس',
        'description' => 'نظام شامل لإدارة المدارس ومتابعة الطلاب والدرجات.',
        'is_archiv' => true,
        'year' => 2023,
        'submission_deadline' => '2023-06-08',
        'file_path' => null,
    ],
    [
        'department_id' => 2,
        'supervisor_id' => 11,
        'title' => 'تطبيق تتبع اللياقة',
        'description' => 'تطبيق لتتبع النشاط الرياضي والصحة واللياقة البدنية.',
        'is_archiv' => false,
        'year' => 2024,
        'submission_deadline' => '2024-06-11',
        'file_path' => null,
    ],
    [
        'department_id' => 3,
        'supervisor_id' => 12,
        'title' => 'نظام إدارة الفنادق',
        'description' => 'نظام لإدارة الحجوزات والغرف وخدمات النزلاء في الفنادق.',
        'is_archiv' => true,
        'year' => 2022,
        'submission_deadline' => '2022-06-01',
        'file_path' => null,
    ],
    [
        'department_id' => 1,
        'supervisor_id' => 13,
        'title' => 'منصة التبرعات',
        'description' => 'منصة إلكترونية لإدارة الحملات الخيرية والتبرعات.',
        'is_archiv' => false,
        'year' => 2024,
        'submission_deadline' => '2024-06-18',
        'file_path' => null,
    ],
    [
        'department_id' => 2,
        'supervisor_id' => 14,
        'title' => 'نظام متابعة الصيانة',
        'description' => 'نظام لإدارة طلبات الصيانة وتتبع حالة الإصلاحات.',
        'is_archiv' => true,
        'year' => 2023,
        'submission_deadline' => '2023-06-02',
        'file_path' => null,
    ],
    [
        'department_id' => 3,
        'supervisor_id' => 15,
        'title' => 'نظام إدارة المستودعات',
        'description' => 'نظام لوجستي لإدارة المستودعات وتتبع المخزون.',
        'is_archiv' => false,
        'year' => 2024,
        'submission_deadline' => '2024-06-14',
        'file_path' => null,
    ],
    [
        'department_id' => 1,
        'supervisor_id' => 16,
        'title' => 'تطبيق حجز مواعيد',
        'description' => 'تطبيق سهل وسريع لحجز المواعيد في مختلف المجالات.',
        'is_archiv' => true,
        'year' => 2023,
        'submission_deadline' => '2023-06-06',
        'file_path' => null,
    ],
    [
        'department_id' => 2,
        'supervisor_id' => 17,
        'title' => 'نظام إدارة المبيعات',
        'description' => 'نظام متكامل لتحليل المبيعات وإدارة العملاء.',
        'is_archiv' => true,
        'year' => 2022,
        'submission_deadline' => '2022-06-03',
        'file_path' => null,
    ],
    [
        'department_id' => 3,
        'supervisor_id' => 18,
        'title' => 'نظام تتبع الشحنات',
        'description' => 'نظام لتتبع الشحنات وتحديث حالة التوصيل للعملاء.',
        'is_archiv' => false,
        'year' => 2024,
        'submission_deadline' => '2024-06-16',
        'file_path' => null,
    ],
    [
        'department_id' => 1,
        'supervisor_id' => 19,
        'title' => 'نظام إدارة الموظفين',
        'description' => 'نظام حديث لإدارة شؤون الموظفين في الشركات.',
        'is_archiv' => true,
        'year' => 2023,
        'submission_deadline' => '2023-06-07',
        'file_path' => null,
    ],
    [
        'department_id' => 2,
        'supervisor_id' => 20,
        'title' => 'تطبيق إعلانات مبوبة',
        'description' => 'تطبيق شامل لنشر الإعلانات المبوبة وتصفحها بسهولة.',
        'is_archiv' => false,
        'year' => 2024,
        'submission_deadline' => '2024-06-19',
        'file_path' => null,
    ],
    [
        'department_id' => 3,
        'supervisor_id' => 21,
        'title' => 'نظام متابعة المشاريع',
        'description' => 'نظام لتحليل تقدم المشاريع وتقديم التقارير اللازمة.',
        'is_archiv' => true,
        'year' => 2022,
        'submission_deadline' => '2022-06-04',
        'file_path' => null,
    ],
    [
        'department_id' => 1,
        'supervisor_id' => 22,
        'title' => 'نظام إدارة الجامعات',
        'description' => 'نظام شامل لإدارة بيانات الطلاب والعمليات الأكاديمية في الجامعات.',
        'is_archiv' => false,
        'year' => 2025,
        'submission_deadline' => '2025-06-20',
        'file_path' => null,
    ],
    [
        'department_id' => 2,
        'supervisor_id' => 22,
        'title' => 'نظام تتبع الأصول',
        'description' => 'نظام متكامل لإدارة أصول الشركات وتتبع حركتها.',
        'is_archiv' => true,
        'year' => 2023,
        'submission_deadline' => '2023-06-09',
        'file_path' => null,
    ],
    [
        'department_id' => 3,
        'supervisor_id' => 22,
        'title' => 'نظام إدارة الشكاوى',
        'description' => 'نظام لإدارة شكاوى العملاء وتتبع حلها.',
        'is_archiv' => false,
        'year' => 2024,
        'submission_deadline' => '2024-06-20',
        'file_path' => null,
    ],
    [
        'department_id' => 1,
        'supervisor_id' => 22,
        'title' => 'نظام إدارة العملاء',
        'description' => 'نظام شامل لإدارة بيانات العملاء وتفاعلاتهم مع الشركة.',
        'is_archiv' => true,
        'year' => 2022,
        'submission_deadline' => '2022-06-05',
        'file_path' => null,
    ]
    ];

    for ($i=0; $i < 3000 ; $i++) {
        $project= [];
        $project['department_id'] = Arr::random([1, 2, 3]);
        $project['supervisor_id'] = Arr::random([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22]);
        $project['title'] = "مشروع " . $i;
        $project['description'] = "وصف المشروع " . $i;
        $project['is_archiv'] = Arr::random([true, false]);
        $project['year'] = Arr::random([2015, 2016,2017,2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026]);
        $project['submission_deadline'] = date('Y-m-d', strtotime("+$i days"));
        $project['file_path'] = null;

        array_push($projects, $project);
    }

     $projectsWithGrades = array_map(function ($project) {
         $project['grade'] = Arr::random(['A', 'B+', 'B', 'C+', 'C', 'F']);
         return $project;
     }, $projects);

     \App\Models\Project::insert($projectsWithGrades);

    }
}
