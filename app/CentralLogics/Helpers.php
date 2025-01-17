<?php

namespace App\CentralLogics;

use App\Models\Country;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class Helpers
{
    
    public static function getCountries(){
        return Country::select('id','name')->get();
    }
    public static function getStates($country_id){
        return Country::select('id','name')->where('country_id',$country_id)->get();
    }
    public static function getCities($state_id){
        return Country::select('id','name')->where('state_id',$state_id)->get();
    }
    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
