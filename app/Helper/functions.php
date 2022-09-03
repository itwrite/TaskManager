<?php

use Illuminate\Support\Arr;

if(!function_exists('page_size')){
    function page_size($limit = 1000){
        return min(request('page_size',15),$limit);
    }
}

if(!function_exists('distance')){
    /**
     * -------------------------------------------
     * -------------------------------------------
     * @param $point1 [longitude,latitude]
     * @param $point2 [longitude,latitude]
     * @return array
     * itwri 2022/6/12 14:21
     */
    function distance($point1, $point2,$type='meters') {
        list($lon1,$lat1,) = $point1;
        list($lon2,$lat2,) = $point2;
        $dist = rad2deg(acos(sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon1 - $lon2))));
        $miles = $dist * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        $arr = compact('miles','feet','yards','kilometers','meters','dist');
        return Arr::get($arr,$type,'meters');
    }
}
