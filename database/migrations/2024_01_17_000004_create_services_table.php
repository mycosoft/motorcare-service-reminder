<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('services', function (Blueprint $table) {
			$table->id();
			$table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
			$table->foreignId('service_type_id')->constrained()->onDelete('restrict');
			$table->date('service_date');
			$table->integer('mileage_at_service');
			$table->decimal('cost', 10, 2);
			$table->text('notes')->nullable();
			$table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
			$table->date('next_service_date')->nullable();
			$table->integer('next_service_mileage')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('services');
	}
};