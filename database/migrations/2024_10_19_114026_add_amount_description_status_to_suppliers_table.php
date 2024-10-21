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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->nullable()->after('postal_code'); // Add amount column
            $table->text('description')->nullable()->after('amount'); // Add description column
            $table->enum('status', ['active', 'inactive'])->default('active')->after('description'); // Add status column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn(['amount', 'description', 'status']); // Drop the added columns
        });
    }
};
