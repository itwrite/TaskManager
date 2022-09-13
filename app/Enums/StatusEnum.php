<?php

namespace App\Enums;


class StatusEnum extends BaseEnum
{
    const ENABLE = 1; //有效
    const DISABLE = 0;//无效

    /**
     * @var string[]
     */
    protected static $labels=[
        self::ENABLE=>'有效',
        self::DISABLE=>'无效',
    ];
}
