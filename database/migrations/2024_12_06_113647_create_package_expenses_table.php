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
        Schema::create('package_expenses', function (Blueprint $table) {
            $table->id();           
            $table->unsignedBigInteger('package_id'); // Foreign key
            $table->foreign('package_id')->references(columns: 'id')->on('packages')->onDelete('cascade');    
           
            $table->unsignedBigInteger('quotation_id')->nullable(); // Add user_id column
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade'); // Add foreign key constraint 
            $table->string('title')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_expenses');
    }
};
