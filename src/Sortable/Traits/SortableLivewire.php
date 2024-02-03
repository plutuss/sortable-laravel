<?php

namespace Plutuss\Sortable\Traits;

use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait SortableLivewire
{

    /**
     * @param Builder $query
     * @param string $sort
     * @return Builder
     */
    public function scopeSort(Builder $query, string $sort): Builder
    {

        $sortables = call_user_func([$this, 'sortables']);

        if ($sort && (in_array($sort, $sortables) || array_key_exists($sort, $sortables))) {

            [$key, $keyword] = $this->sortableFieldDivider($sort, $sortables);

            return $query->orderBy($key, $keyword);
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
