<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'name',
		'description',
		'base_price',
		'estimated_hours',
		'is_active'
	];

	protected $casts = [
		'base_price' => 'decimal:2',
		'estimated_hours' => 'integer',
		'is_active' => 'boolean'
	];

	public function services()
	{
		return $this->hasMany(Service::class);
	}

	public function serviceSchedules()
	{
		return $this->hasMany(ServiceSchedule::class);
	}
}