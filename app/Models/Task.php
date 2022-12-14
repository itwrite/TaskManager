<?php

namespace App\Models;

use App\Traits\ModelTimeFormatTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Task.
 *
 * @package namespace App\Models;
 */
class Task extends Model implements Transformable
{
    use TransformableTrait,ModelTimeFormatTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
