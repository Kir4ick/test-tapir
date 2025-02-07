<?php

namespace App\Services;

use App\Clients\CRMClient;
use App\Jobs\ProcessQuestionnaire;
use App\Models\Car;
use App\Models\Questionnaire;
use App\Models\Enums\SendStatusEnum;
use Illuminate\Support\Facades\Mail;

class QuestionnaireService
{

    public function __construct(
        private readonly CRMClient $crmClient
    )
    {}

    /**
     * Создание заявки
     *
     * @param string $phone
     * @param string $email
     * @param int $carId
     *
     * @return Questionnaire|null
     */
    public function createQuestionnaire(string $phone, string $email, int $carId): Questionnaire|null
    {
        $car = Car::query()->find($carId);
        if (!$car) {
            return null;
        }

        $questionnaire = Questionnaire::query()->create([
            'phone' => $phone,
            'car_id' => $car->id,
            'send_status' => SendStatusEnum::PENDING,
        ]);

        Mail::raw('Какой-то текст об отправке mail', function ($message) use ($email) {
            $message->to($email)->subject('Отправка заявки');
        });

        $sendResult = $this->sendQuestionnaire($questionnaire, $car->vin);
        if (!$sendResult) {
            ProcessQuestionnaire::dispatch($questionnaire)->delay(now()->addMinutes());
        }

        return $questionnaire;
    }

    /**
     * Отправка заявки изменение статуса её
     *
     * @param Questionnaire $questionnaire
     * @param string $vin
     *
     * @return bool
     */
    public function sendQuestionnaire(Questionnaire $questionnaire, string $vin): bool
    {
        $result = $this->crmClient->sendQuestionnaire($questionnaire->phone, $vin);

        if ($result) {
            $questionnaire->send_status = SendStatusEnum::SUCCESS->value;
            $questionnaire->save();
        }

        return $result;
    }
}
