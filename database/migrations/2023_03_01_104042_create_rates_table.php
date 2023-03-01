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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->date('rate_date');
            $table->float('rate_value', 8, 2);
            $table->unsignedBigInteger('currency_id')->index();
            $table->timestamps();
        });

        Schema::table('rates', function (Blueprint $table) {
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rates', function (Blueprint $table) {
            $table->dropForeign('rates_currency_id_foreign');
        });

        Schema::dropIfExists('rates');
    }
};
