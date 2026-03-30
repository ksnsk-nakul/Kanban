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
        Schema::create('currency_conversion', function (Blueprint $table) {
            $table->id();
            $table->char('from_currency_code', 3);
            $table->char('to_currency_code', 3);
            $table->decimal('rate', 18, 8);
            $table->boolean('active')->default(true)->index();
            $table->timestamps();

            $table->unique(['from_currency_code', 'to_currency_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currency_conversion');
    }
};
