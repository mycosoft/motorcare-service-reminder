<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Imports\CustomersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CustomerController extends Controller
{
	public function index(Request $request)
	{
		$query = Customer::query();

		if ($request->has('search') && $request->search) {
			$search = $request->search;
			$query->where(function($q) use ($search) {
				$q->where('name', 'like', "%{$search}%")
				  ->orWhere('email', 'like', "%{$search}%")
				  ->orWhere('phone', 'like', "%{$search}%");
			});
		}

		if ($request->has('city') && $request->city) {
			$query->where('city', $request->city);
		}

		$customers = $query->latest()->paginate(10)->withQueryString();
		$cities = Customer::select('city')->whereNotNull('city')->distinct()->pluck('city');
		return view('customers.index', compact('customers', 'cities'));
	}

	public function create()
	{
		return view('customers.create');
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|email|unique:customers',
			'phone' => 'required|string|unique:customers',
			'address' => 'nullable|string',
			'city' => 'nullable|string',
			'state' => 'nullable|string',
			'postal_code' => 'nullable|string',
			'notification_preference_email' => 'boolean',
			'notification_preference_sms' => 'boolean'
		]);

		Customer::create($validated);

		return redirect()->route('customers.index')
			->with('success', 'Customer created successfully.');
	}

	public function show(Customer $customer)
	{
		return view('customers.show', compact('customer'));
	}

	public function edit(Customer $customer)
	{
		return view('customers.edit', compact('customer'));
	}

	public function update(Request $request, Customer $customer)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|email|unique:customers,email,' . $customer->id,
			'phone' => 'required|string|unique:customers,phone,' . $customer->id,
			'address' => 'nullable|string',
			'city' => 'nullable|string',
			'state' => 'nullable|string',
			'postal_code' => 'nullable|string',
			'notification_preference_email' => 'boolean',
			'notification_preference_sms' => 'boolean'
		]);

		$customer->update($validated);

		return redirect()->route('customers.index')
			->with('success', 'Customer updated successfully.');
	}

	public function destroy(Customer $customer)
	{
		$customer->delete();

		return redirect()->route('customers.index')
			->with('success', 'Customer deleted successfully.');
	}

	/**
	 * Import customers from CSV/Excel file
	 */
	public function import(Request $request)
	{
		$request->validate([
			'file' => 'required|file|mimes:csv,xlsx'
		]);

		try {
			Excel::import(new CustomersImport, $request->file('file'));

			return redirect()->route('customers.index')
				->with('success', 'Customers imported successfully.');
		} catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
			$failures = $e->failures();
			$errors = collect($failures)->map(function ($failure) {
				return "Row {$failure->row()}: {$failure->errors()[0]}";
			})->join('<br>');

			return redirect()->route('customers.index')
				->with('error', "Import failed:<br>{$errors}")
				->withErrors($e->errors());
		}
	}

	/**
	 * Download customer import template
	 */
	public function downloadTemplate(): BinaryFileResponse
	{
		$headers = [
			'Content-Type' => 'text/csv',
			'Content-Disposition' => 'attachment; filename="customer_import_template.csv"',
		];

		$template = storage_path('app/templates/customer_import_template.csv');

		if (!file_exists($template)) {
			// Create template if it doesn't exist
			$handle = fopen($template, 'w');
			fputcsv($handle, ['name', 'email', 'phone', 'address', 'city', 'state', 'postal_code']);
			fputcsv($handle, ['John Doe', 'john@example.com', '+256700000000', '123 Main St', 'Kampala', 'Central', '00000']);
			fclose($handle);
		}

		return response()->download($template, 'customer_import_template.csv', $headers);
	}
}