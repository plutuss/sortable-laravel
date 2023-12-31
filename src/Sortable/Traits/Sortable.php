<?php

namespace Plutuss\Sortable\Traits;

use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait Sortable
{


    /**
     * @param Builder $query
     * @return Builder
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function scopeSort(Builder $query): Builder
    {

        $sortables = call_user_func([$this, 'sortables']);

        $sort = request()->get('sort');

        if ($sort && (in_array($sort, $sortables) || array_key_exists($sort, $sortables))) {

            [$key, $keyword] = $this->sortableFieldDivider($sort, $sortables);

            return $query->orderBy($key, $keyword);
        }

        return $query->when(!request()->has('sort'), function ($query) {
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
