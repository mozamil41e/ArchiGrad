<?php

use App\Actions\Projects\ArchiveProject;
use App\Enums\Grade;
use App\Exceptions\ProjectArchivingException;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// ─── الحالة 1: المشروع بدون ملف ────────────────────────────────────────────

test('يرفع استثناء إذا لم يكن للمشروع ملف', function () {
    $project = Project::factory()->create([
        'file_path' => null,
        'grade'     => Grade::A,
        'is_archiv' => false,
    ]);

    expect(fn () => (new ArchiveProject)->execute($project))
        ->toThrow(ProjectArchivingException::class, 'عذراً، لا يمكن أرشفة المشروع بدون ملف');
});

// ─── الحالة 2: المشروع بدون درجة (Pending) ─────────────────────────────────

test('يرفع استثناء إذا كانت درجة المشروع Pending', function () {
    $project = Project::factory()->create([
        'file_path' => 'projects/test.pdf',
        'grade'     => Grade::Pending,
        'is_archiv' => false,
    ]);

    expect(fn () => (new ArchiveProject)->execute($project))
        ->toThrow(ProjectArchivingException::class, 'عذراً، لا يمكن أرشفة المشروع بدون درجة');
});

// ─── الحالة 3: الملف غير موجود فعلياً في التخزين ───────────────────────────

test('يرفع استثناء إذا كان الملف غير موجود في التخزين', function () {
    Storage::fake('public');

    $project = Project::factory()->create([
        'file_path' => 'projects/missing.pdf',
        'grade'     => Grade::A,
        'is_archiv' => false,
    ]);

    expect(fn () => (new ArchiveProject)->execute($project))
        ->toThrow(ProjectArchivingException::class, 'عذراً، الملف غير موجود حالياً');
});

// ─── الحالة 4: الأرشفة تتم بنجاح ───────────────────────────────────────────

test('يتم تحديث is_archiv إلى true عند اكتمال الشروط', function () {
    Storage::fake('public');

    $filePath = 'projects/report.pdf';

    Storage::disk('public')->put($filePath, 'محتوى تجريبي');

    $project = Project::factory()->create([
        'file_path' => $filePath,
        'grade'     => Grade::BPlus,
        'is_archiv' => false,
    ]);

    (new ArchiveProject)->execute($project);

    expect($project->fresh()->is_archiv)->toBeTrue();
});
