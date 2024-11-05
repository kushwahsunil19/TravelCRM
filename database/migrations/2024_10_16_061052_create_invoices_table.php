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
        Schema::create('invoices', function (Blueprint $table) {
           
                $table->id();
                $table->unsignedBigInteger('branch_id'); // Foreign key
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade'); // Foreign key constraint
                $table->unsignedBigInteger('agent_id'); // Foreign key
                $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');    
                $table->unsignedBigInteger('package_id'); // Foreign key
                $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
                $table->integer('bank_id')->nullable();
                $table->string('invoice_no')->unique(); // Unique quotation number              
                $table->decimal('vat', 10, 2)->nullable();
                $table->string('discount_type')->nullable();// Package Name
                $table->decimal('discount', 10, 2)->nullable();
                $table->text('note')->nullable();
                $table->text('term_condition')->nullable();
                $table->tinyInteger('status')->default(2)->comment('0 for Declined, 1 for Accepted, 2 for Sent, 3 for Expired');
              
                $table->timestamps();
                $table->softDeletes(); //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
