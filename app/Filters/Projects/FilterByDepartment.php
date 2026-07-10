<?php

namespace App\Filters\Projects;

use App\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByDepartment implements Filter
{
    public function __construct(private readonly mixed $departmentId)
    {
    }

    public function handle(Builder $query, Closure $next): Builder
    {
        return $next($this->departmentId ? $query->where('department_id', $this->departmentId) : $query);
    }
}
