<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
   protected $guarded = [
     'id'
   ];
   public function user()
   {
       return $this->belongsTo('\App\Models\Stock');//stockテーブルのくせにuserテーブルのデータを参照できるやつ
   }
}
