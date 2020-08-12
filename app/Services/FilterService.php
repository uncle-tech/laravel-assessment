<?php

namespace App\Services;
use Illuminate\Support\Collection;

class FilterService
{
    protected function arrayService()
    {
        return new ArrayService;
    }

    public function paginate(
        Collection $collection,
        $offset = null,
        $limit = null
    ) : Collection {
        if (\is_numeric($offset))
            return $this->paginate($collection->skip($offset), null, $limit);

        if (\is_numeric($limit))
            return $collection->take($limit);

        return $collection;
    }

    protected function comparisonOps()
    {
        return [
            'eq' => '=',
            'lt' => '<', 
            'gt' => '>',
        ];
    }

    protected function validParams()
    {
        return [
            'price',
            'start',
            'end',
        ];
    }

    protected function applyFilter(
        Collection $collection,
        array $filter
    ) : Collection {
        if (\count($filter) < 3)
            return $collection;

        if (!\in_array($filter[0], $this->validParams()))
            return $collection;

        if (!\in_array($filter[1], \array_keys($this->comparisonOps())))
            return $collection;

        return $collection->where(
            $filter[0],
            $this->comparisonOps()[$filter[1]],
            $filter[2]
        );
    }

    protected function filterValidParams($params)
    {
        return \array_filter($params, function($key) {
            return \in_array($key, $this->validParams());
        }, \ARRAY_FILTER_USE_KEY);
    }

    protected function formatFilters($filters)
    {
        return \array_map(function($filter) {
            /* 
             * the filter is already in the form [
             *     attr, [
             *         [operator, value]
             *     ]
             * ]
             * must put in the form [attr, operator, value]
             */
            return [
                $filter[0],
                $filter[1][0][0],
                $filter[1][0][1],
            ];
        }, $this->arrayService()->entries($this->filterValidParams($filters)));
    }

    public function applyFilters(
        Collection $collection,
        array $filters
    ) : Collection {
        return $this->paginate(
            \array_reduce($this->formatFilters($filters), function($c, $fltr) {
                return $this->applyFilter($c, $fltr);
            }, $collection),
            \array_key_exists('offset', $filters) ? $filters['offset'] : null,
            \array_key_exists('limit', $filters) ? $filters['limit'] : null
        );
    }

}
