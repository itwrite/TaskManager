<?php

use Illuminate\Support\Arr;

if(!function_exists('page_size')){
    function page_size($limit = 1000){
        return min(request('page_size',15),$limit);
    }
}

if(!function_exists('setting')){

    /**
     * @param $key
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @author zzp
     * @date 2022/9/5
     */
    function setting($key,$value=null){
        /**
         * @var \App\Services\SettingService
         */
        $service = app()->make(\App\Services\SettingService::class);
        if(func_num_args()==1){
            return $service->get($key);
        }
        return $service->set($key,$value);
    }
}
