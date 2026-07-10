<?php

namespace App\Actions\Projects;

use App\Models\Project;

class SyncProjectStudents
{
    public function execute(Project $project, array $students, int|string $departmentId): void
    {
        $project->students()->delete();

        foreach ($students as $student) {
            $name = trim($student['name'] ?? '');
            $universityNumber = trim($student['university_number'] ?? '');

            if ($name === '' || $universityNumber === '') {
                continue;
            }

            $project->students()->create([
                'name' => $name,
                'department_id' => $departmentId,
                'university_number' => $universityNumber,
            ]);
        }
    }
}
