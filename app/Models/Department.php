<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;

    public $fillable = [
        'name',
    ];
    public function projects()
    {
        return $this->hasMany(Project::class, 'department_id', 'id');
    }

    public function supervisors()
    {
        return $this->hasMany(Supervisor::class, 'department_id', 'id');
    }


    public function students()
    {
        return $this->hasMany(Student::class, 'department_id', 'id');
    }
}
