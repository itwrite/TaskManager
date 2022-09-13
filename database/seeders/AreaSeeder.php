<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Repositories\AreaRepository;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    protected $repository;

    public function __construct(AreaRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $areas = json_decode(file_get_contents(__DIR__."/data/areas.json"),1);
        $china = $this->repository->find(86);
        foreach ($areas as $provinceArr) {
            $province = $this->repository->create($this->convertToInsertData(
                $provinceArr['code'],
                $provinceArr['name'],
                $china->id,1,
                implode(',',[$china->id,$provinceArr['code']]
                )));
            if($province && !empty($provinceArr['children'])){
                foreach ($provinceArr['children'] as $cityArr) {
                    $city = $this->repository->create($this->convertToInsertData(
                        $cityArr['code'],
                        $cityArr['name'],
                        $province->id,2,
                        implode(',',[$china->id,$provinceArr['code'],$cityArr['code']])
                    ));
                    if($city && !empty($cityArr['children'])){
                        foreach ($cityArr['children'] as $areaArr) {
                            $this->repository->create($this->convertToInsertData(
                                $areaArr['code'],
                                $areaArr['name'],
                                $city->id,3,
                                implode(',',[$china->id,$provinceArr['code'],$cityArr['code'],$areaArr['code']])
                            ));
                        }
                    }
                }
            }
        }
    }

    protected function convertToInsertData($id,$name,$parentId,$level = 0,$chains=''){
        return ['id'=>$id,'name'=>$name,'parent_id'=>$parentId,'status'=>StatusEnum::ENABLE,'level'=>$level,'chains'=>$chains];
    }
}
