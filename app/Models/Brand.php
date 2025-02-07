<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Brand
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Car[] $cars
 *
 * @package App\Models
 */
class Brand extends Model
{
	protected $fillable = [
		'name'
	];

	public function cars(): HasMany
	{
		return $this->hasMany(Car::class);
	}
}
