<?php

namespace App\Providers;

use App\Clients\CarClient;
use App\Clients\CRMClient;
use App\Jobs\ProcessQuestionnaire;
use App\Parsers\CarParser;
use App\Services\QuestionnaireService;
use Illuminate\Foundation\Application;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CarClient::class, function (Application $app) {
            return new CarClient(
                config('integrations.new_cars'),
                config('integrations.old_cars'),
                $app->get(CarParser::class)
            );
        });

        $this->app->bind(CRMClient::class, function (Application $app) {
            return new CRMClient(config('integrations.crm'));
        });

        $this->app->bindMethod([ProcessQuestionnaire::class, 'handle'], function (ProcessQuestionnaire $processQuestionnaire, Application $app) {
            return $processQuestionnaire->handle($app->make(QuestionnaireService::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}
