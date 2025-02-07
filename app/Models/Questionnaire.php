<?php

namespace App\Models;

use App\Observers\QuestionnaireObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $send_status
 *
 * @property User $user
 * @property Car $car
 */
#[ObservedBy(QuestionnaireObserver::class)]
class Questionnaire extends Model
{

    use AsSource;

    protected $fillable = [
        'send_status',
        'phone',
        'user_id',
        'car_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
