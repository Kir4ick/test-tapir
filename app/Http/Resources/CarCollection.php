<?php

namespace App\Http\Resources;

use App\Http\Resources\Abstracts\AbstractPaginateCollection;
use App\Models\Car;
use Illuminate\Http\Request;

class CarCollection extends AbstractPaginateCollection
{

    /**
     * @inheritdoc
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function (Car $item) {
            return [
                'id' => $item->id,
                'model' => $item->model,
                'brand' => $item->brand->name,
                'vin' => $item->vin,
                'price' => $item->price,
                'year' => $item->year,
                'mileage' => $item->mileage,
                'brandId' => $item->brand_id,
                'createdAt' => $item->created_at,
                'updatedAt' => $item->updated_at,
            ];
        })->toArray();
    }

}
