<?php

namespace App\Filters;

use App\Filters\Abstracts\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class CarFilter extends AbstractFilter
{

    protected function getCallbacks(): array
    {
        return [
            'model' => [$this, 'model'],
            'vin' => [$this, 'vin'],
            'priceFrom' => [$this, 'priceFrom'],
            'priceTo' => [$this, 'priceTo'],
            'yearFrom' => [$this, 'yearFrom'],
            'yearTo' => [$this, 'yearTo'],
            'mileageFrom' => [$this, 'mileageFrom'],
            'mileageTo' => [$this, 'mileageTo'],
            'brandId' => [$this, 'brandId'],
        ];
    }

    public function model(Builder $builder, string $model): void
    {
        $builder->where('model', $model);
    }

    public function vin(Builder $builder, string $vin): void
    {
        $builder->where('vin', $vin);
    }

    public function priceFrom(Builder $builder, int $priceFrom): void
    {
        $builder->where('price', '>=', $priceFrom);
    }

    public function priceTo(Builder $builder, int $priceTo): void
    {
        $builder->where('price', '<=', $priceTo);
    }

    public function yearFrom(Builder $builder, int $yearFrom): void
    {
        $builder->where('year', '>=', $yearFrom);
    }

    public function yearTo(Builder $builder, int $yearTo): void
    {
        $builder->where('year', '<=', $yearTo);
    }

    public function mileageFrom(Builder $builder, int $mileageFrom): void
    {
        $builder->where('mileage', '>=', $mileageFrom);
    }

    public function mileageTo(Builder $builder, int $mileageTo): void
    {
        $builder->where('mileage', '<=', $mileageTo);
    }

    public function brandId(Builder $builder, int $brandId): void
    {
        $builder->where('brand_id', $brandId);
    }
}
