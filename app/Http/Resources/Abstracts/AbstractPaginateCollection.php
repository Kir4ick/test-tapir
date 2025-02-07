<?php

namespace App\Http\Resources\Abstracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * @mixin LengthAwarePaginator
 */
abstract class AbstractPaginateCollection extends ResourceCollection
{

    /**
     * @inheritdoc
     */
    public function withResponse(Request $request, JsonResponse $response): void
    {
        $responseData = $response->getData(true);

        unset($responseData['meta']);
        unset($responseData['links']);

        $responseData['total'] = $this->total();
        $responseData['currentPage'] = $this->currentPage();
        $responseData['items'] = $responseData['data'];

        unset($responseData['data']);

        $response->setData($responseData);
    }

}
