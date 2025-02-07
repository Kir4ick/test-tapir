<?php

namespace App\Observers;

use App\Models\Questionnaire;
use Illuminate\Support\Facades\Auth;

class QuestionnaireObserver
{
    public function creating(Questionnaire $questionnaire): void
    {
        $questionnaire->user_id = Auth::id();
    }
}
