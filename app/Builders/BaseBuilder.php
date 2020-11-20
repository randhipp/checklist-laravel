<?php

namespace App\Builders;

use App\Pagination;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;

class BaseBuilder extends Builder
{
    /**
     * Create a new paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \App\Pagination\CustomPaginator
     */
    protected function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(\App\Pagination\CustomPaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }
}
