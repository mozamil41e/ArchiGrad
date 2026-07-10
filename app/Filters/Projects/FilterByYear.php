<?php

namespace App\Filters\Projects;

use App\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByYear implements Filter
{
    public function __construct(private readonly mixed $year)
    {
    }

    public function handle(Builder $query, Closure $next): Builder
    {
        return $next($this->year ? $query->where('year', $this->year) : $query);
    }
}
