<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AreaRepository.
 *
 * @package namespace App\Repositories;
 */
interface AreaRepository extends RepositoryInterface
{
    /**
     * -------------------------------------------
     * -------------------------------------------
     * @param array $where
     * @param array $orderBy
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     * itwri 2022/7/3 22:38
     */
    public function getList($where = [],$orderBy=[]);

    /**
     * 详情
     * @param $id
     * @return mixed
     * @author zzp
     * @date 2022/6/15
     */
    public function getDetail($id);

    /**
     * -------------------------------------------
     * 全国数据
     * -------------------------------------------
     * @param false $flat
     * @return mixed
     * itwri 2022/7/3 1:44
     */
    public function getChinaData($flat=false);
}
