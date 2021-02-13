<?php

namespace App\Http\Controllers;

use App\Models\Stock; //追加
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index() //追加
    {
        return view('top');
    }
    public function images() //追加
    {
        $stocks = Stock::where('genre', 'image')->get();//genreがimageのレコード（あわせてページネーションするには？）
        //$stocks = Stock::Paginate(6)->where('genre', 'image')->get();
        //$stocks = Stock::Paginate(6); //Eloquantで検索
        return view('images', compact('stocks'));
    }
}
