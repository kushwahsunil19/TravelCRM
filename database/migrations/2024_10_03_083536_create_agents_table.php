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
        Schema::create('agents', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // agent's name
            $table->string('mobile'); // agent's mobile number
            $table->string('email')->unique(); // agent's email address
            $table->string('city')->nullable();  // City
            $table->string('state')->nullable();  // State
            $table->string('country')->nullable();  // Country
            $table->string('image')->nullable();  // Country
            $table->timestamps(); // Created at and updated at timestamps
            $table->softDeletes(); // Soft delete timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
