<?php

namespace App\Exceptions\ErrorCode;

/**
 * @method static INVALID_TYPE()
 * @method static INVALID_FILE()
 * @method static INVALID_PARAMS()
 */
class UploadError extends ErrorCode
{
    /**
     * ----------------------------------------
     * 文件上传相关 701***
     * ----------------------------------------
     */
    const INVALID_PARAMS                            = 701001;
    const INVALID_FILE                              = 701002;
    const INVALID_TYPE                              = 701003;

    protected static $messages = [
        self::INVALID_PARAMS                        =>'参数错误',
        self::INVALID_FILE                          =>"文件错误",
        self::INVALID_TYPE                          =>"上传类型错误"
    ];
}
