<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Car
 *
 * @property int $id
 * @property string $model
 * @property string $vin
 * @property int $price
 * @property bool $is_new
 * @property int $year
 * @property int $mileage
 * @property int $brand_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Brand $brand
 *
 * @package App\Models
 */
class Car extends Model
{

    use Filterable;

	protected $casts = [
		'price' => 'int',
		'is_new' => 'bool',
		'year' => 'int',
		'mileage' => 'int',
		'brand_id' => 'int'
	];

	protected $fillable = [
		'model',
		'vin',
		'price',
		'is_new',
		'year',
		'mileage',
		'brand_id'
	];

	public function brand(): BelongsTo
	{
		return $this->belongsTo(Brand::class);
	}
}
