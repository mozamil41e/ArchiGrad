<?php

namespace App\Filters\Projects;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class ProjectFilters
{
    public function apply(Builder $query, array $filters): Builder
    {
        return app(Pipeline::class)
            ->send($query)
            ->through([
                new FilterBySearch($filters['search'] ?? null),
                new FilterByYear($filters['year'] ?? null),
                new FilterByDepartment($filters['department_id'] ?? null),
                new FilterBySupervisor($filters['supervisor_id'] ?? null),
                new FilterByArchiveStatus($filters['is_archiv'] ?? null),
            ])
            ->thenReturn();
    }
}
