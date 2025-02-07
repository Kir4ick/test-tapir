<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CarListRequest;
use App\Http\Resources\CarCollection;
use App\Services\CarService;
use Illuminate\Http\JsonResponse;

class CarController
{

    public function __construct(
        private readonly CarService $carService,
    )
    {}

    public function index(CarListRequest $request)
    {
        $paginateList = $this->carService->paginateList($request->validated(), $request->query('page'));

        return new CarCollection($paginateList);
    }

    public function import(): JsonResponse
    {
        $this->carService->import();

        return response()->json(['status' => true]);
    }
}
