<?php

namespace Plutuss\Sortable\Traits;

use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait SortableWithQueryString
{
    use MainSortable;

    /**
     * @param Builder $query
     * @param string $sort
     * @param callable|null $callback
     * @return Builder
     */
    public function scopeSort(Builder $query, string $sort, callable $callback = null): Builder
    {

        $sortables = call_user_func([$this, 'sortables']);

        if ($this->requestSortableCheck($sort, $sortables)) {

            [$key, $keyword] = $this->sortableFieldDivider($sort, $sortables);

            $query = $query->orderBy($key, $keyword);

            if (!empty($callback) && $callback instanceof \Closure) {
                return $callback($query) ?? $query;
            }

            return $query;
        }


        return $query->when(empty($sort), function ($query) {
            $query->orderBy(config('sortable.default.field'), config('sortable.default.keyword'));
        });
    }

}
