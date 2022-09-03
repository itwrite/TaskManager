<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


/**
 * a simple helper function
 * @param $class
 * @param $action
 * @return string
 * @author zzp
 * @date 2022/5/24
 */
if(!function_exists('toAction')){
    function toAction($class,$action){
        $class = Str::startsWith("\\",$class)?$class:"\\".$class;
        return implode("@",[$class,$action]);
    }
}

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//不需要登录授权的
Route::group(['middleware' => ['organization.auth']], function () {
    Route::post('/user/auth/login',toAction(\App\Http\Controllers\User\AuthController::class,'login'));

    //需要登录授权的
    Route::group(['middleware' => ['jwt.auth',]], function () {
        //
        Route::get('/user/auth/info',toAction(\App\Http\Controllers\User\AuthController::class,'info'));
    });
});


