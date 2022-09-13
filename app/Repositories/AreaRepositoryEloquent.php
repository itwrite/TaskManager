<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\Area;
use App\Validators\AreaValidator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class AreaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AreaRepositoryEloquent extends BaseRepository implements AreaRepository
{
    protected $columns = ['id','name', 'level','parent_id','latitude','longitude','chains'];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Area::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AreaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getDetail($id)
    {
        $area = $this->find($id,$this->columns);
        if(!$area){
            throw new \Exception('找不到数据');
        }

        $area->chains_list  =  $this->model->whereRaw(sprintf("find_in_set(id,'%s')",$area->chains))->where('status','=',StatusEnum::ENABLE)->orderByRaw(sprintf("find_in_set(id,'%s') asc",$area->chains))->get();

        return $area;
    }

    /**
     * -------------------------------------------
     * -------------------------------------------
     * @param array $where
     * @param array $orderBy
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     * itwri 2022/7/3 22:38
     */
    public function getList($where = [], $orderBy = [])
    {
        return $this->model->where($where)->select($this->columns)->get();
    }

    /**
     * -------------------------------------------
     * -------------------------------------------
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     * itwri 2022/7/3 1:17
     */
    public function getChinaData($flat=false){
        return Cache::remember(__METHOD__,3000,function () use($flat){

            $country_id = 86;

            $country = $this->model->newQuery()->find($country_id);

            $columns = ['id','name', 'level','parent_id'];
            //结构为分页结构，但这里是全国数据，所以把perPage调大，保证获取的是全国数据
            if($flat == true){
                return $this->model->newQuery()->where(['status'=>StatusEnum::ENABLE])->whereRaw("LEFT(`chains`,5) = '{$country->chains},'")->select($columns)->get();
            }
            return $this->model->with(['children'=>function(HasMany $query){
                return $query->with(['children'])->where(['status'=>StatusEnum::ENABLE]);
            }])->where(['status'=>StatusEnum::ENABLE,'parent_id'=>$country_id])->select($columns)->get();
        });

    }
}
