<?php

namespace Plutuss\Sortable\Traits;

trait MainSortable
{
    /**
     * @param mixed $sort
     * @param mixed $sortables
     * @return bool
     */
    private function requestSortableCheck(mixed $sort, mixed $sortables): bool
    {
        return $sort && (in_array($sort, $sortables) || array_key_exists($sort, $sortables));
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