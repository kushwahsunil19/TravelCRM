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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('suplyer_id'); // Foreign key
            $table->foreign('suplyer_id')->references(columns: 'id')->on('suppliers')->onDelete('cascade'); 
            
            $table->unsignedBigInteger('invoice_id'); // Foreign key
            $table->foreign('invoice_id')->references(columns: 'id')->on('invoices')->onDelete('cascade');    

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
