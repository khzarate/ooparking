<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParkingFeeController extends Controller
{
    public function getTimeDifference($time_in, $time_out){
        $time_in = strtotime($time_in);
        $time_out = strtotime($time_out);
        $difference = round(abs($time_out - $time_in) / 3600,2);
        return ceil($difference);
    }

    public function parkingFeeComputation($time, $parking_slot_type){
        $parking_fee = 0;
        if($time > 3){
            if($time > 24){
                $parking_fee = floor($time/24) * 5000;
                $time%=24;
            }
            switch ($parking_slot_type) {
                case '1':
                    $parking_fee+=$time * 20;
                    break;
                case '2':
                    $parking_fee+=$time * 60;
                    break;
                case '3':
                    $parking_fee+=$time * 100;
                    break;
            }
        } else {
            $parking_fee = 40;	
        }

        return $parking_fee;
    }
}
