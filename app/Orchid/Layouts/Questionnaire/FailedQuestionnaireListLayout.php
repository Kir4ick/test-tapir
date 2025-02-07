<?php

namespace App\Orchid\Layouts\Questionnaire;

use App\Models\Questionnaire;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class FailedQuestionnaireListLayout extends Table
{

    public $target = 'list';

    protected function columns(): iterable
    {
        return [
            TD::make('phone', __('Phone'))
                ->render(fn (Questionnaire $questionnaire) => $questionnaire->phone),

            TD::make('email', __('Email'))
                ->render(fn (Questionnaire $questionnaire) => $questionnaire->user->email),

            TD::make('vinNumber', __('VIN'))
                ->render(fn (Questionnaire $questionnaire) => $questionnaire->car->vin),

            TD::make('created_at', __('Creating'))
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->sort(),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Questionnaire $questionnaire) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Button::make(__('Retry'))
                            ->icon('bs.trash3')
                            ->method('retryQuestionnaire', [
                                'id' => $questionnaire->id,
                            ]),
                    ])),
        ];
    }

}
