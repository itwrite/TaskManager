<?php

namespace App\Exceptions\ErrorCode;

/**
 * @method static LOGIN_FAILED();
 * @method static PASSWORD_WRONG();
 * @method static UNAUTHENTICATED();
 * @method static USER_NOT_EXISTS();
 * @method static PERMISSION_LIMIT();
 * @method static NOT_AN_ADMINISTRATOR();
 */
class AuthError extends ErrorCode
{
    /**
     * ----------------------------------
     * 授权相关 401***
     * 密码登录、微信登录、管理后台登录、登出
     * ----------------------------------
     */
    const LOGIN_FAILED                              = 401001;
    const PASSWORD_WRONG                            = 401002;
    const UNAUTHENTICATED                           = 401003;
    const USER_NOT_EXISTS                           = 401004;
    const PERMISSION_LIMIT                          = 401005;
    const NOT_AN_ADMINISTRATOR                      = 401006;


    public static $messages = [
        self::LOGIN_FAILED                          => "登录失败",
        self::UNAUTHENTICATED                       => "未授权",
        self::PASSWORD_WRONG                        => "密码错误",
        self::USER_NOT_EXISTS                       => "用户不存在",
        self::PERMISSION_LIMIT                      => "没有权限",
        self::NOT_AN_ADMINISTRATOR                  => "不是管理员",
    ];
}
