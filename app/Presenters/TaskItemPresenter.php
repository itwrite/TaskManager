<?php

namespace App\Presenters;

use App\Transformers\TaskItemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TaskItemPresenter.
 *
 * @package namespace App\Presenters;
 */
class TaskItemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TaskItemTransformer();
    }
}
