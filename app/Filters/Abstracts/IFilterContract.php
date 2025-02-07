<?php

namespace App\Filters\Abstracts;

use Illuminate\Database\Eloquent\Builder;

interface IFilterContract
{
    public function apply(Builder $builder, array $queryParams): void;
}
