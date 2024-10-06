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
        Schema::create('partners', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Partner's name
            $table->string('mobile'); // Partner's mobile number
            $table->string('email')->unique(); // Partner's email address
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
        Schema::dropIfExists('partners');
    }
};
