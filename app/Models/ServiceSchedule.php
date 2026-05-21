<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceSchedule extends Model
{
	use HasFactory, SoftDeletes;

	const STATUS_PENDING = 'pending';
	const STATUS_COMPLETED = 'completed';
	const STATUS_CANCELLED = 'cancelled';

	protected $fillable = [
		'vehicle_id',
		'service_type_id',
		'scheduled_date',
		'expected_mileage',
		'notes',
		'status',
		'last_notification_sent',
		'notification_attempts'
	];

	protected $casts = [
		'scheduled_date' => 'date',
		'last_notification_sent' => 'datetime',
		'expected_mileage' => 'integer',
		'notification_attempts' => 'integer'
	];

	/**
	 * Get the route key for the model.
	 *
	 * @return string
	 */
	public function getRouteKeyName()
	{
		return 'id';
	}

	/**
	 * Retrieve the model for a bound value.
	 *
	 * @param  mixed  $value
	 * @param  string|null  $field
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function resolveRouteBinding($value, $field = null)
	{
		return $this->withTrashed()->where($field ?? $this->getRouteKeyName(), $value)->firstOrFail();
	}

	public function vehicle()
	{
		return $this->belongsTo(Vehicle::class);
	}

	public function serviceType()
	{
		return $this->belongsTo(ServiceType::class);
	}

	public function getCustomerAttribute()
	{
		return $this->vehicle->customer ?? null;
	}

	public function scopeUpcoming($query)
	{
		return $query->where('status', self::STATUS_PENDING)
					->whereDate('scheduled_date', '>=', now())
					->orderBy('scheduled_date');
	}

	public function scopeOverdue($query)
	{
		return $query->where('status', self::STATUS_PENDING)
					->whereDate('scheduled_date', '<', now())
					->orderBy('scheduled_date');
	}

	public function getStatusBadgeClassAttribute()
	{
		return [
			self::STATUS_PENDING => 'warning',
			self::STATUS_COMPLETED => 'success',
			self::STATUS_CANCELLED => 'danger',
		][$this->status] ?? 'secondary';
	}
}