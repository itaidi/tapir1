<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CarsController extends Controller
{
    //
    public function frontend(Request $request){

        // очистка бд
        if($request->input('clear')){ Cars::truncate(); } 

        // поиск
        $year_from=(int) $request->input('year_from');
        $year_to=(int) $request->input('year_to');
        $price_less=(int) $request->input('price_less');

        // проверочный запрос
        // http://localhost:7777/api/store?year_from=2000&year_to=2010&price_less=1500000

        $select = Cars:://whereBetween(
            //'created_at', array(
            //    Carbon::createFromDate($year_from, 1, 1),
            //    Carbon::createFromDate($year_to, 12, 31)
            //))
            where([
                'year'=>['$gte'=>$year_from, '$lte'=>$year_to], // ge gte больше или равно
                'price'=>['$lt'=>$price_less],
                ])
            ->limit(10000)
            ->orderBy('year','DESC')
            ->get();//->where('price',['$lt'=>$price_less])->get();

            return response()->json($select, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE);

        //return Cars::all();
    }
}
