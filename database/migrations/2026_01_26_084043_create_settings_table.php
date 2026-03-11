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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('RENAX');
            $table->string('logo')->nullable();
            
            // Contact Info
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('whatsapp')->nullable();
            
            // Social Media
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('facebook')->nullable();
            
            // Work Hours
            $table->string('work_hours_weekdays')->nullable();
            $table->string('work_hours_friday')->nullable();
            
            $table->text('footer_description')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
