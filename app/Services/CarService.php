<?php

namespace App\Services;

use App\Clients\CarClient;
use App\Filters\CarFilter;
use App\Models\Brand;
use App\Models\Car;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CarService
{

    public function __construct(
        private CarClient $client,
    )
    {}

    public function paginateList(array $filters, int $page = 0): LengthAwarePaginator
    {
        return Car::filter(app()->make(CarFilter::class), $filters)
            ->with(['brand'])
            ->paginate(page: $page);
    }

    /**
     * Импорт данных про машин
     *
     * @return bool
     */
    public function import(): bool
    {
        $newCars = $this->client->getNewCars();
        $oldCars = $this->client->getOldCars();

        if ($newCars == null || $oldCars == null) {
            return false;
        }

        try {
            $this->processImportCars(array_merge($newCars, $oldCars));
        } catch (\Exception $exception) {
            Log::error('Error importing new cars: ' . $exception->getMessage());
            return false;
        }

        return true;
    }

    /**
     * Обработка и вставка массива данных про машин
     *
     * @param array $carArray
     *
     * @return void
     */
    private function processImportCars(array $carArray): void
    {
        $brandList = array_map(fn (array $item) => $item['brand'], $carArray);
        $brandList = array_unique($brandList);
        $brandList = array_map(fn (string $item) => ['name' => $item], $brandList);

        $brandList = $this->getBrandList($brandList);

        $carArray = array_map(function (array $item) use ($brandList) {
            $item['brand_id'] = $brandList[$item['brand']];
            unset($item['brand']);

            return $item;
        }, $carArray);

        Car::query()->upsert($carArray, 'vin');
    }

    /**
     * Получение массива, где ключ - название марки машины, а значение id
     *
     * @param array $brandList
     *
     * @return array<string, string>
     */
    private function getBrandList(array $brandList): array
    {
        Brand::query()->upsert($brandList, 'name');
        $brandList = Brand::query()
            ->get(['id', 'name'])
            ->toArray();

        $newBrandList = [];
        foreach ($brandList as $brand) {
            $newBrandList[$brand['name']] = $brand['id'];
        }

        return $newBrandList;
    }
}
