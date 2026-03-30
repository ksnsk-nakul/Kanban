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
        Schema::create('assistant_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('category', 32)->index();
            $table->string('title');
            $table->text('notes')->nullable();
            $table->date('due_date')->nullable()->index();
            $table->timestamp('reminder_at')->nullable();
            $table->timestamp('completed_at')->nullable()->index();
            $table->unsignedTinyInteger('priority')->default(0)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistant_tasks');
    }
};
