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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('recaptcha_site_key')->nullable();
            $table->string('recaptcha_secret_key')->nullable();
            $table->boolean('recaptcha_enabled_contact')->default(false);
            $table->boolean('recaptcha_enabled_booking')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'recaptcha_site_key',
                'recaptcha_secret_key',
                'recaptcha_enabled_contact',
                'recaptcha_enabled_booking'
            ]);
        });
    }
};
