<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'vehicle_id',
		'service_type_id',
		'service_date',
		'mileage_at_service',
		'cost',
		'notes',
		'status',
		'next_service_date',
		'next_service_mileage'
	];

	protected $casts = [
		'service_date' => 'date',
		'next_service_date' => 'date',
		'mileage_at_service' => 'integer',
		'next_service_mileage' => 'integer',
		'cost' => 'decimal:2'
	];

	public function vehicle()
	{
		return $this->belongsTo(Vehicle::class);
	}

	public function serviceType()
	{
		return $this->belongsTo(ServiceType::class);
	}
}