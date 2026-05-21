<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		'name',
		'email',
		'phone',
		'address',
		'city',
		'state',
		'postal_code',
		'notification_preference_email',
		'notification_preference_sms'
	];

	protected $casts = [
		'notification_preference_email' => 'boolean',
		'notification_preference_sms' => 'boolean'
	];

	public function vehicles()
	{
		return $this->hasMany(Vehicle::class);
	}
}