<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorIdToOrderhistoriesTableOrderhistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderhistories', function (Blueprint $table) {
            $table->string('author_id')->default(1);  //ここに追加カラムの情報
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderhistories', function (Blueprint $table) { 
            $table->dropColumn('author_id');  //ここに追加カラムの情報 
        }); 
    }
}
