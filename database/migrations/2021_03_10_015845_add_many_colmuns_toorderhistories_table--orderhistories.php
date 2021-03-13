<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddManyColmunsToorderhistoriesTableOrderhistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderhistories', function (Blueprint $table) {
            $table->string('name');//商品名
            $table->string('genre');//ジャンル
            $table->string('subgenre');//ジャンル
            $table->string('tag1');//tag
            $table->string('tag2');//tag
            $table->string('tag3');//tag
            $table->string('tag4');//tag
            $table->string('tag5');//tag
            $table->string('detail');//詳細
            $table->string('path');//ファイルのパス
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
