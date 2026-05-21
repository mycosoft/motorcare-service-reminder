<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('vehicles', function (Blueprint $table) {
			$table->id();
			$table->foreignId('customer_id')->constrained()->onDelete('cascade');
			$table->string('make');
			$table->string('model');
			$table->string('year');
			$table->string('registration_number')->unique();
			$table->string('vin_number')->unique();
			$table->string('color')->nullable();
			$table->integer('current_mileage')->default(0);
			$table->date('last_service_date')->nullable();
			$table->integer('service_interval_months')->default(6);
			$table->integer('service_interval_miles')->default(5000);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('vehicles');
	}
};