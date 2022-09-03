<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Handler extends Request
{
    public function wantsJson()
    {
        //api 接口的,统一强制返回json格式
        return Str::startsWith($this->pathInfo,'/api/') || parent::expectsJson();
    }
}
