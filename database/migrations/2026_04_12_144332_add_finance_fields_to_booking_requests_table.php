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
            $table->decimal('monthly_installment', 12, 2)->nullable()->after('car_price');
            $table->decimal('down_payment', 12, 2)->nullable()->after('monthly_installment');
            $table->integer('finance_period')->nullable()->after('down_payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_requests', function (Blueprint $table) {
            $table->dropColumn(['monthly_installment', 'down_payment', 'finance_period']);
        });
    }
};
