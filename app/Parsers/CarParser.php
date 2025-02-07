<?php

namespace App\Parsers;

use App\Parsers\Abstracts\AbstractParser;
use Carbon\Carbon;

class CarParser extends AbstractParser
{

    protected function mapArray(array $array): array
    {
        if (isset($array['vehicle'])) {
            $array = $array['vehicle'];
        }

        $newArray = [];

        $now = Carbon::now();
        $needleKeys = ['model', 'vin', 'price'];

        foreach ($array as $item) {
            # Валидация приходящего массива
            foreach ($needleKeys as $needleKey) {
                if (!isset($item[$needleKey])) {
                    continue 2;
                }
            }

            $item['price'] = (int)$item['price'];
            $item['is_new'] = !isset($item['mileage']) && !isset($item['year']);
            $item['year'] = $item['year'] ?? $now->year;
            $item['mileage'] = $item['mileage'] ?? 0;

            $newArray[] = $item;
        }

        return $newArray;
    }

}
