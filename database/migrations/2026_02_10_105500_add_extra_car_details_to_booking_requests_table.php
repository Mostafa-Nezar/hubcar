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
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->string('brand_name')->nullable()->after('car_name_manual');
            $table->string('car_type')->nullable()->after('brand_name');
            $table->string('car_category')->nullable()->after('car_type');
            $table->decimal('car_price', 12, 2)->nullable()->after('model_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->dropColumn(['brand_name', 'car_type', 'car_category', 'car_price']);
        });
    }
};
