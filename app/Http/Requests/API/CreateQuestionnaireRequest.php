<?php

namespace App\Http\Requests\API;

use App\Models\Questionnaire;
use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionnaireRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|string|regex:/^\+7\d{10}$/',
            'carId' => [
                'required',
                'exists:cars,id',
                function ($attribute, $value, $fail) {
                    $existQuestionnaire = Questionnaire::query()
                        ->where('user_id', $this->user()->id)
                        ->where('car_id', $value)
                        ->exists();

                    if ($existQuestionnaire) {
                        $fail(__('questionnaire already exists'));
                    }
                },
            ],
        ];
    }
}
