<?php

namespace App\Orchid\Screens\Questionnaire;

use App\Models\Questionnaire;
use App\Models\Enums\SendStatusEnum;
use App\Orchid\Layouts\Questionnaire\FailedQuestionnaireListLayout;
use App\Services\QuestionnaireService;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class FiledQuestionnairesScreen extends Screen
{

    public function __construct(
        private readonly QuestionnaireService $questionnaireService,
    )
    {}

    public function query(): iterable
    {
        return [
            'list' => Questionnaire::query()
                ->with(['car', 'user'])
                ->where('send_status', SendStatusEnum::ERROR->value)
                ->paginate()
        ];
    }

    public function layout(): iterable
    {
        return [
            FailedQuestionnaireListLayout::class
        ];
    }

    public function retryQuestionnaire(int $id): void
    {
        $questionnaire = Questionnaire::query()->findOrFail($id);
        $result = $this->questionnaireService->sendQuestionnaire($questionnaire, $questionnaire->car->vin);

        $result ? Alert::success('Success') : Alert::error('Retry failed');
    }
}
