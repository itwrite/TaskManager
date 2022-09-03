<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Setting;

/**
 * Class SettingTransformer.
 *
 * @package namespace App\Transformers;
 */
class SettingTransformer extends TransformerAbstract
{
    /**
     * Transform the Setting entity.
     *
     * @param \App\Models\Setting $model
     *
     * @return array
     */
    public function transform(Setting $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
