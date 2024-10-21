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
        Schema::table('invoices', function (Blueprint $table) {
            // Add the currency_id column
            $table->unsignedBigInteger('currency_id')->after('package_id'); // Make sure to adjust the position as needed

            // Add the foreign key constraint
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop the foreign key constraint and the column
            $table->dropForeign(['currency_id']);
            $table->dropColumn('currency_id');
        });
    }
};
