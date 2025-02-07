<?php

namespace App\Models\Traits;

use App\Filters\Abstracts\IFilterContract;
use Illuminate\Database\Eloquent\Builder;

/**
 * Трейт для возможности фильтрации модели
 *
 * @method static Builder filter(IFilterContract $filter, array $filterData)
 */
trait Filterable
{
    public function scopeFilter(Builder $builder, IFilterContract $contract, array $filterData): Builder
    {
        $contract->apply($builder, $filterData);

        return $builder;
    }
}
