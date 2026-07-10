<?php

namespace App\Filters\Projects;

use App\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterBySupervisor implements Filter
{
    public function __construct(private readonly mixed $supervisorId)
    {
    }

    public function handle(Builder $query, Closure $next): Builder
    {
        return $next($this->supervisorId ? $query->where('supervisor_id', $this->supervisorId) : $query);
    }
}
