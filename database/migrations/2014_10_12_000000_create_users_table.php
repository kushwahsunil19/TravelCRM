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
        Schema::create('users', function (Blueprint $table) {
            $table->id();  
            $table->bigInteger("role_id")->default(0); // Set default to 0 for normal users or admin
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();            
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('profile')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 for Deactive, 1 for Active');
                $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

        });
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
     
        Schema::dropIfExists('users');
       
      
    }
};
