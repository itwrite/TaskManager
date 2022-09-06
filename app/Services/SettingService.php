<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    protected static $data = [];

    protected $repository;
    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $key
     * @return Collection
     * @author zzp
     * @date 2022/9/5
     */
    public function get($key){
        return collect($this->all())->firstWhere('key','=',$key);
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     * @author zzp
     * @date 2022/9/5
     */
    public function set($key,$value){
        $item = $this->get($key);
        if(empty($item)){
            return false;
        }
        $item->value = $value;
        return $item->save();
    }

    /**
     * @return array|mixed
     * @author zzp
     * @date 2022/9/5
     */
    public function all(){
        if(empty(self::$data)){
            self::$data = Cache::remember(__CLASS__,0,function (){
               return $this->repository->all();
            });
        }
        return self::$data;
    }
}
