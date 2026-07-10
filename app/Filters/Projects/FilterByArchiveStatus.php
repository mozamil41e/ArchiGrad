<?php

namespace App\Filters\Projects;

use App\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByArchiveStatus implements Filter
{
    public function __construct(private readonly mixed $isArchived)
    {
    }

    public function handle(Builder $query, Closure $next): Builder
    {
        $hasValue = $this->isArchived !== null && $this->isArchived !== '';

        return $next($hasValue ? $query->where('is_archiv', $this->isArchived) : $query);
    }
}
