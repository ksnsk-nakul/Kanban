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
        Schema::table('users', function (Blueprint $table) {
            $table->string('locale', 10)->nullable()->index();
            $table->string('theme_mode', 16)->default('light')->index();
            $table->json('theme_palette')->nullable();
            $table->string('stage', 32)->default('learning')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['locale', 'theme_mode', 'theme_palette', 'stage']);
        });
    }
};
