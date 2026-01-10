<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description', // This is 'summary' in the form
        'department_id',
        'supervisor_id',
        'grade',
        'year',
        'submission_deadline', // This is 'defenseDate' in the form
        'is_archiv',
        'file_path',
    ];

    protected $casts = [
        'submission_deadline' => 'date',
        'year' => 'integer',
        'is_archiv' => 'boolean',
    ];

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'project_id');
    }
}
