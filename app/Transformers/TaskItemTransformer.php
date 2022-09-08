<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TaskItem;

/**
 * Class TaskItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class TaskItemTransformer extends TransformerAbstract
{
    /**
     * Transform the TaskItem entity.
     *
     * @param \App\Models\TaskItem $model
     *
     * @return array
     */
    public function transform(TaskItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
