<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('service_schedules', function (Blueprint $table) {
			$table->id();
			$table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
			$table->foreignId('service_type_id')->constrained()->onDelete('restrict');
			$table->date('scheduled_date');
			$table->integer('expected_mileage')->nullable();
			$table->text('notes')->nullable();
			$table->enum('status', ['pending', 'notified', 'confirmed', 'completed', 'cancelled'])->default('pending');
			$table->timestamp('last_notification_sent')->nullable();
			$table->integer('notification_attempts')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('service_schedules');
	}
};