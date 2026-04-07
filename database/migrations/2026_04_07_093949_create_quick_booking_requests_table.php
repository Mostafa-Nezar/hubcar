<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quick_booking_requests', function (Blueprint $table) {
            $table->id();
            $table->string('payment_type'); // cash, finance
            $table->string('client_name');
            $table->string('phone');
            $table->foreignId('car_id')->nullable()->constrained()->onDelete('set null');
            $table->string('car_name_manual')->nullable(); // In case car is deleted
            $table->string('brand_name')->nullable();
            $table->string('car_type')->nullable();
            $table->string('car_category')->nullable();
            $table->decimal('car_price', 12, 2)->nullable();
            $table->integer('model_year')->nullable();
            $table->string('city')->nullable();
            $table->timestamp('request_date')->useCurrent();
            $table->string('status')->default('New'); // New, Contacted, Interested, Not Interested, Completed
            $table->string('state_category')->default('New'); // Same as status or similar
            $table->string('bank_name')->nullable();
            $table->string('work_sector')->nullable();
            $table->decimal('monthly_salary', 12, 2)->nullable();
            $table->text('client_notes')->nullable();
            $table->text('internal_notes')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('last_status_update')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_booking_requests');
    }
};
