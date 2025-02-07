<?php

namespace App\Filters\Abstracts;

use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter implements IFilterContract
{


    public function apply(Builder $builder, array $queryParams): void
    {
        foreach ($this->getCallbacks() as $paramName => $callback) {
            if (!isset($queryParams[$paramName])) {
                continue;
            }

            call_user_func($callback, $builder, $queryParams[$paramName]);
        }
    }

    /**
     * Метод для связи [поле => метод]
     *
     * @return array<string, callable>
     */
    abstract protected function getCallbacks(): array;
}
