<?php

namespace App\Actions\Projects;

use App\Enums\Grade;
use App\Exceptions\ProjectArchivingException;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ArchiveProject
{
    public function execute(Project $project): void
    {
        if (! $project->file_path) {
            throw new ProjectArchivingException('عذراً، لا يمكن أرشفة المشروع بدون ملف');
        }

        if ($project->grade === Grade::Pending) {
            throw new ProjectArchivingException('عذراً، لا يمكن أرشفة المشروع بدون درجة');
        }

        if (! Storage::disk('public')->exists($project->file_path)) {
            throw new ProjectArchivingException('عذراً، الملف غير موجود حالياً');
        }

        $project->update(['is_archiv' => true]);
    }
}
