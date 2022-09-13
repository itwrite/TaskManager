<?php

namespace App\Exceptions\ErrorCode;

/**
 * @method static Error()
 */
class SystemError extends ErrorCode
{
    /**
     * -------------------------------------------------
     * 系统错误 101***
     * -------------------------------------------------
     */
    const Error                         = 101001;

    public static $messages = [
        self::Error                     => "出错了"
    ];
}
