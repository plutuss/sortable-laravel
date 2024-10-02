<?php

namespace Plutuss\Sortable\Traits;

use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait Sortable
{

    use MainSortable;

    /**
     * @param Builder $query
     * @return Builder
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function scopeSort(Builder $query): Builder
    {

        $sortables = call_user_func([$this, 'sortables']);

        $sort = request()->get(config('sortable.request_key'));

        if ($this->requestSortableCheck($sort, $sortables)) {

            [$key, $keyword] = $this->sortableFieldDivider($sort, $sortables);

            return $query->orderBy($key, $keyword);
        }

        return $query->when(!request()->has('sort'), function ($query) {
            $query->orderBy(config('sortable.default.field'), config('sortable.default.keyword'));
        });
    }

}
