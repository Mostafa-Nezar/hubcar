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
        Schema::table('seo_pages', function (Blueprint $table) {
            $table->string('seo_robots')->nullable()->default('index, follow');
            $table->string('canonical_url')->nullable();
            
            // Open Graph
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_type')->nullable()->default('website');
            
            // Twitter
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_card')->nullable()->default('summary_large_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_pages', function (Blueprint $table) {
            $table->dropColumn([
                'seo_robots',
                'canonical_url',
                'og_title',
                'og_description',
                'og_type',
                'twitter_title',
                'twitter_description',
                'twitter_card',
            ]);
        });
    }
};
