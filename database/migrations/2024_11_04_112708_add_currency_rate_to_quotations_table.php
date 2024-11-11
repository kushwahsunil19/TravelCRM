<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyRateToQuotationsTable extends Migration
{
    public function up()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->decimal('currency_rate', 15, 2)->default(0.00)->after('currency_id'); // Add currency_rate after currency_id
        });
    }

    public function down()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('currency_rate'); // Remove the currency_rate column if rolled back
        });
    }
}
