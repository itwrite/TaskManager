<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait ModelTimeFormatTrait
{
    /**
     * @param $attr
     * @return string
     * @author zzp
     * @date 2022/6/9
     */
    public function getCreatedAtAttribute($attr) {
        return Carbon::parse($attr)->format('Y-m-d H:i:s'); //Change the format to whichever you desire
    }

    /**
     * @param $attr
     * @return string
     * @author zzp
     * @date 2022/6/9
     */
    public function getUpdatedAtAttribute($attr) {
        return Carbon::parse($attr)->format('Y-m-d H:i:s'); //Change the format to whichever you desire
    }
}
