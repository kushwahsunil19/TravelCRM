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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Currency name (e.g., Indian Rupee)
            $table->string('code', 3); // Currency code (e.g., INR, USD)
            $table->string('symbol', 10)->nullable(); // Currency symbol (nullable)
            $table->decimal('exchange_rate', 15, 2)->nullable(); // Exchange rate (nullable)
            $table->boolean('status')->default(0); // Nullable status (active/inactive)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
