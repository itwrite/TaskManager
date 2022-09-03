<?php

namespace App\Providers;

use App\Helper\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(255);

        //自定议全局分页
        $this->app->singleton(
            LengthAwarePaginator::class,
            Paginator::class
        );

        /**
         * 在debug模式下打印SQL
         */
        if(config('app.debug') == true){
            $this->logSql();
        }
    }

    /**
     * -------------------------------------------
     * 日志里打印SQL
     * -------------------------------------------
     * itwri 2022/7/1 23:12
     */
    protected function logSql(){
        DB::listen(function ($query) {
            $sql = str_replace('?', "'%s'", $query->sql);
            $qBindings = [];
            foreach ($query->bindings as $key => $value) {
                if (is_numeric($key)) {
                    $qBindings[] = $value;
                } else {
                    $sql = str_replace(':'.$key, "'{$value}'", $sql);
                }
            }
            $sql = vsprintf($sql, $qBindings);
            $sql = str_replace("\\", "", $sql);
            Log::info('Execute sql: '.$sql.'; [time:'.$query->time.'ms] ');
        });
    }
}
