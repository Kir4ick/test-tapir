<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateQuestionnaireRequest;
use App\Models\Enums\SendStatusEnum;
use App\Services\QuestionnaireService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class QuestionnaireController
{
    public function __construct(
        private readonly QuestionnaireService $service
    )
    {}

    public function store(CreateQuestionnaireRequest $request)
    {
        $user = Auth::user();
        $result = $this->service->createQuestionnaire(
            $request->input('phone'),
            $user->email,
            $request->input('carId'),
        );

        $responseMessagesCondition = [
            SendStatusEnum::SUCCESS->value => 'Заявка успешно создана',
            SendStatusEnum::PENDING->value => 'Заявка создана и в очереди на отправление'
        ];

        return response()->json(
            ['message' => $responseMessagesCondition[$result?->send_status] ?? ''],
            $result ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
        );
    }
}
