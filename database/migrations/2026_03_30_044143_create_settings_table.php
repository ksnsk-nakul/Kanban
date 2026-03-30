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
            $table->foreignId('settings_group_id')->constrained('settings_groups')->cascadeOnDelete();
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('type', 16)->default('string');
            $table->boolean('is_public')->default(false)->index();
            $table->boolean('is_encrypted')->default(false)->index();
            $table->timestamps();

            $table->unique(['settings_group_id', 'key']);
            $table->index('key');
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
