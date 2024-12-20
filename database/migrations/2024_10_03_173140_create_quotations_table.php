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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Add user_id column
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Add foreign key constraint
            $table->unsignedBigInteger('branch_id'); // Foreign key
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade'); // Foreign key constraint
            $table->unsignedBigInteger('partner_id'); // Foreign key
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');    
            $table->unsignedBigInteger('package_id'); // Foreign key
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            
            $table->integer('bank_id')->nullable();
            $table->integer('quotation_no')->unique();  
            $table->string('booking_reference_no')->unique()->nullable();
            $table->integer('no_of_night')->default(0)->nullable();
            $table->integer('no_of_infant')->default(0)->nullable();
            $table->integer('no_of_child')->default(0)->nullable();
            $table->integer('no_of_adult')->default(0)->nullable();
            $table->integer('no_of_passenger')->default(0)->nullable();
            $table->decimal('gst_tax', 10, 2)->default(0.00)->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount', 10, 2)->default(0.00)->nullable();
            $table->text('note')->nullable();
            $table->text('term_condition')->nullable();
            $table->tinyInteger('status')->default(2)->comment('0 for Declined, 1 for Accepted, 2 for Sent, 3 for Expired');
            $table->dateTime('arrival_datetime')->nullable();
            $table->dateTime('departure_datetime')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Soft delete timestamp
    
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
