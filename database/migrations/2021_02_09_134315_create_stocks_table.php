<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name', '100');//商品名
            $table->string('genre', '100');//ジャンル
            $table->string('subgenre', '100')->nullable();//ジャンル
            $table->string('tag1', '100');//tag
            $table->string('tag2', '100');//tag
            $table->string('tag3', '100');//tag
            $table->string('tag4', '100');//tag
            $table->string('tag5', '100');//tag
            $table->string('detail', '500');//詳細
            $table->integer('fee');//金額
            $table->string('path', '200');//ファイルのパス
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
