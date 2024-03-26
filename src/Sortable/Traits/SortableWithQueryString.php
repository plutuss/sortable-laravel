<?php

namespace Plutuss\Sortable\Traits;

use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait SortableWithQueryString
{

    /**
     * @param Builder $query
     * @param string $sort
     * @param callable|null $callback
     * @return Builder
     */
    public function scopeSort(Builder $query, string $sort, callable $callback = null): Builder
    {

        $sortables = call_user_func([$this, 'sortables']);

        if ($sort && (in_array($sort, $sortables) || array_key_exists($sort, $sortables))) {

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

    /**
     * @param string $sort
     * @param array $sortables
     * @return mixed
     */
    private function sortableFieldDivider(string $sort, array $sortables): mixed
    {
        if (array_key_exists($sort, $sortables)) {
            return $sortables[$sort];
        }

        return explode('_', $sort);
    }

}
