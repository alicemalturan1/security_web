<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public static function encode_date($date){
        $date= Carbon::parse($date);
        $day=$date->day;
        $months=['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'];
        $month=$months[$date->month-1];
        $year = $date->year;
        $year = Carbon::now()->year==$year?'':$year;
        $hour=$date->hour;
        $minute = $date->minute;
        if($minute<10)$minute="0".$minute;
        if($hour<10)$minute="0".$hour;

        return $day.' '.$month.' '.$year.' '.$hour.' : '.$minute;
    }
}
