<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Area.
 *
 * @package namespace App\Entities;
 */
class Area extends Model implements Transformable
{
    use TransformableTrait;

    protected $columns = ['id','name', 'level','parent_id','latitude','longitude'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'parent_code',
        'status'
    ];

    public function parent(){
        return $this->belongsTo(Area::class,'parent_id','id')->select($this->columns)->where('status','=',StatusEnum::ENABLE);
    }

    public function children(){
        return $this->hasMany(Area::class,'parent_id','id')->select($this->columns)->where('status','=',StatusEnum::ENABLE);
    }
}
