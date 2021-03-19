<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;//追記（DBファサードを使えるようにする記述）

class StockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->truncate(); //2回目実行の際にシーダー情報をクリア
        DB::table('stocks')->insert([
           'name' => 'ドローン',
           'genre'=>'image',
           'subgenre'=>'イラスト',
           'tag1'=>'DJI',
           'tag2'=>'ガジェット',
           'tag3'=>'あ',
           'tag4'=>'あ',
           'tag5'=>'あ',
           'detail' => '説明文説明文',
           'fee' => 200000, 
           'user_id' => 1,
           'path' => 'a.jpg',
       ]);
        DB::table('stocks')->insert([
           'name' => 'OL',
           'genre'=>'image',
           'subgenre'=>'写真',
           'tag1'=>'可愛い',
           'tag2'=>'メガネ',
           'tag3'=>'スーツ',
           'tag4'=>'',
           'tag5'=>'',
           'detail' => '説明文説明文',
           'fee' => 200000, 
           'user_id' => 1,
           'path' => 'b.jpg',
       ]);
        DB::table('stocks')->insert([
           'name' => 'MAC',
           'genre'=>'image',
           'subgenre'=>'3D',
           'tag1'=>'apple',
           'tag2'=>'高級',
           'tag3'=>'パソコン',
           'tag4'=>'PC',
           'tag5'=>'',
           'detail' => '説明文説明文',
           'fee' => 200000, 
           'user_id' => 1,
           'path' => 'c.jpg',
       ]);
        DB::table('stocks')->insert([
           'name' => 'ペンギン',
           'genre'=>'image',
           'subgenre'=>'イラスト',
           'tag1'=>'可愛い',
           'tag2'=>'臭い',
           'tag3'=>'寒そう',
           'tag4'=>'モノクロ',
           'tag5'=>'',
           'detail' => '説明文説明文',
           'fee' => 200000, 
           'user_id' => 1,
           'path' => 'd.jpg',
       ]);
        DB::table('stocks')->insert([
           'name' => 'シャチ',
           'genre'=>'image',
           'subgenre'=>'写真',
           'tag1'=>'肉食',
           'tag2'=>'かっこいい',
           'tag3'=>'',
           'tag4'=>'',
           'tag5'=>'',
           'detail' => '説明文説明文',
           'fee' => 200000, 
           'user_id' => 1,
           'path' => 'e.jpg',
       ]);
        DB::table('stocks')->insert([
           'name' => 'パンダ',
           'genre'=>'movie',
           'subgenre'=>'イラスト',
           'tag1'=>'モノクロ',
           'tag2'=>'草食',
           'tag3'=>'',
           'tag4'=>'',
           'tag5'=>'',
           'detail' => '説明文説明文',
           'fee' => 200000, 
           'user_id' => 1,
           'path' => 'f.jpg',
       ]);
       DB::table('stocks')->insert([
        'name' => 'OL2',
        'genre'=>'image',
        'subgenre'=>'写真',
        'tag1'=>'可愛い',
        'tag2'=>'メガネ',
        'tag3'=>'スーツ',
        'tag4'=>'',
        'tag5'=>'',
        'detail' => '説明文説明文',
        'fee' => 200000, 
        'user_id' => 1,
        'path' => 'g.jpg',
    ]);
    DB::table('stocks')->insert([
        'name' => 'OL3',
        'genre'=>'image',
        'subgenre'=>'写真',
        'tag1'=>'可愛い',
        'tag2'=>'メガネ',
        'tag3'=>'スーツ',
        'tag4'=>'',
        'tag5'=>'',
        'detail' => '説明文説明文',
        'fee' => 200000, 
        'user_id' => 1,
        'path' => 'h.jpg',
    ]);
    }
}
