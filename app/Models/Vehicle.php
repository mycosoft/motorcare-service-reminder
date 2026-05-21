<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'customer_id',
		'make',
		'model',
		'year',
		'registration_number',
		'vin_number',
		'color',
		'current_mileage',
		'last_service_date',
		'service_interval_months',
		'service_interval_miles'
	];

	protected $casts = [
		'last_service_date' => 'date',
		'current_mileage' => 'integer',
		'service_interval_months' => 'integer',
		'service_interval_miles' => 'integer'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function services()
	{
		return $this->hasMany(Service::class);
	}

	public function serviceSchedules()
	{
		return $this->hasMany(ServiceSchedule::class);
	}
}