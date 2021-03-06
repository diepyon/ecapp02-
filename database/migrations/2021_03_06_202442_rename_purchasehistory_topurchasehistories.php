<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePurchasehistoryTopurchasehistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::rename('変更前のテーブル名', '変更後のテーブル名');
        // という形でテーブル名の変更を指定します。
        Schema::rename('purchasehistory', 'purchasehistories');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // ロールバック時にテーブル名の変更を巻き戻すようにします。
        Schema::rename('purchasehistories', 'purchasehistory');
    }
}
