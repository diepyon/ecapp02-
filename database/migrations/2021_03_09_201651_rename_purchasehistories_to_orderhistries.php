<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePurchasehistoriesToOrderhistries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderhistries', function (Blueprint $table) {
            Schema::rename('purchasehistories', 'orderhistories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderhistries', function (Blueprint $table) {
           Schema::rename('orderhistories', 'purchasehistories');
        });
    }
}
