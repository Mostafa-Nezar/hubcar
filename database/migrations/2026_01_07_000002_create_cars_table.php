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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('type'); // SUV, Sedan, etc.
            $table->string('category')->nullable();
            $table->integer('model_year');
            $table->decimal('price', 12, 2);
            $table->string('condition')->default('new'); // new, used
            $table->string('availability_status')->default('available'); // available, sold, reserved
            $table->text('main_image')->nullable();
            $table->json('specs')->nullable();
            $table->text('other_specs')->nullable();
            $table->text('description')->nullable();
            $table->integer('seats')->nullable();
            $table->integer('doors')->nullable();
            $table->string('transmission')->nullable();
            $table->string('luggage')->nullable();
            $table->string('fuel_type')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
