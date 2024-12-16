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
        Schema::create('packages', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('package_name'); // Package Name
            $table->text('description')->nulleble(); // Description
            $table->decimal('infant_amount', 10, 2)->default(0.00)->nullable(); 
            $table->decimal('child_amount', 10, 2)->default(0.00)->nullable(); 
            $table->decimal('adult_amount', 10, 2)->default(0.00)->nullable(); 
            $table->decimal('amount', 10, 2)->default(0.00)->nullable();            
            $table->decimal('net_amount', 10, 2)->default(0.00)->nullable();  
            $table->timestamps(); // Created at and updated at timestamps
            $table->softDeletes(); // Soft delete timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
