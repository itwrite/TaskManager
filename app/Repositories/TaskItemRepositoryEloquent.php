<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TaskItemRepository;
use App\Models\TaskItem;
use App\Validators\TaskItemValidator;

/**
 * Class TaskItemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TaskItemRepositoryEloquent extends BaseRepository implements TaskItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TaskItem::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TaskItemValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
