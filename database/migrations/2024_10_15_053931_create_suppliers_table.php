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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('currency_id'); // Foreign key
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade'); // Foreign key constraint
            $table->decimal('currency_rate', 15, 2)->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->integer('city_id')->nullable();  // City
            $table->integer('state_id')->nullable();  // State
            $table->integer('country_id')->nullable();  // Country
            $table->string('postal_code')->nullable();          
            $table->string('image')->nullable(); // In case you have a supplier logo or image
            $table->timestamps();
            $table->softDeletes(); // For soft deleting the supplier
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
