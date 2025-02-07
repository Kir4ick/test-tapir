<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class CarListRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model' => 'string',
            'vin' => 'string',
            'priceFrom' => 'integer',
            'priceTo' => 'integer',
            'yearFrom' => 'integer',
            'yearTo' => 'integer',
            'mileageFrom' => 'integer',
            'mileageTo' => 'integer',
            'brandId' => 'integer|exists:brands,id',
            'page' => 'integer',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('page')) {
            $this->merge(['page' => 0]);
        }
    }

}
