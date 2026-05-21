<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class CustomersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
	use SkipsErrors;

	public function model(array $row)
	{
		return new Customer([
			'name' => $row['name'],
			'email' => $row['email'],
			'phone' => $row['phone'],
			'address' => $row['address'] ?? null,
			'city' => $row['city'] ?? null,
			'state' => $row['state'] ?? null,
			'postal_code' => $row['postal_code'] ?? null,
			'notification_preference_email' => true,
			'notification_preference_sms' => true,
		]);
	}

	public function rules(): array
	{
		return [
			'name' => 'required|string|max:255',
			'email' => 'required|email|unique:customers,email',
			'phone' => 'required|string|unique:customers,phone',
			'address' => 'nullable|string',
			'city' => 'nullable|string',
			'state' => 'nullable|string',
			'postal_code' => 'nullable|string',
		];
	}
}