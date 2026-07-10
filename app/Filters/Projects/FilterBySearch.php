<?php

namespace App\Filters\Projects;

use App\Filters\Filter;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterBySearch implements Filter
{
    public function __construct(private readonly ?string $search)
    {
    }

    public function handle(Builder $query, Closure $next): Builder
    {
        if (! $this->search) {
            return $next($query);
        }

        return $next($query->where(
            fn(Builder $q) => $q->where('id', $this->search)
                ->orWhere('title', 'like', "%{$this->search}%")
                ->orWhere('description', 'like', "%{$this->search}%")
        ));
    }
}
