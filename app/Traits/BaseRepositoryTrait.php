<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait BaseRepositoryTrait
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @param $field
     * @param $prefix
     * @return string
     * @author zzp
     * @date 2022/6/29
     */
    protected function fullField($field,$prefix = null){
        return (empty($prefix) ? $this->model->getTable():$prefix).".".$field;
    }
}
