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
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description_1');
            $table->text('description_2')->nullable();
            $table->string('exp_label')->default('عاماً من الخبرة');
            $table->string('exp_value')->default('15+');
            $table->string('clients_label')->default('عميل سعيد');
            $table->string('clients_value')->default('5000+');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
