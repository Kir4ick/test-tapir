<?php

use App\Http\Controllers\API\CarController;
use App\Http\Controllers\API\QuestionnaireController;
use Illuminate\Support\Facades\Route;

Route::apiResource('car', CarController::class, [
    'only' => ['index'],
]);
Route::post('car/import', [CarController::class, 'import']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('questionnaire', QuestionnaireController::class, [
        'only' => ['store'],
    ]);
});
