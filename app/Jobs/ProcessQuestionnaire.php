<?php

namespace App\Jobs;

use App\Clients\CRMClient;
use App\Models\Enums\SendStatusEnum;
use App\Models\Questionnaire;
use App\Services\QuestionnaireService;
use DateTime;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessQuestionnaire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 10;

    public int $backoff = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Questionnaire $questionnaire
    ) {}

    /**
     * Execute the job.
     */
    public function handle(QuestionnaireService $questionnaireService): void
    {
        $result = $questionnaireService->sendQuestionnaire($this->questionnaire, $this->questionnaire->car->vin);
        if (!$result) {
            throw new Exception();
        }
    }

    public function failed(\Throwable $exception): void
    {
        $this->questionnaire->send_status = SendStatusEnum::ERROR->value;
        $this->questionnaire->save();

        $emailText = sprintf(
            'Не удалось отправить заявку в CRM. Номер телефона: %s, VIN автомобиля: %s',
            $this->questionnaire->phone,
            $this->questionnaire->car->vin
        );

        Mail::raw($emailText, function ($message) {
            $message->to(config('integrations.admin_email'))->subject('Ошибка отправки в CRM');
        });
    }
}
