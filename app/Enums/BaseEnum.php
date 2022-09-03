<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

abstract class BaseEnum extends Enum
{
    protected static $labels = [];
    protected $label;
    public function __construct($value)
    {
        parent::__construct($value);

        $this->label = static::$labels[$this->getValue()]??"";
    }

    /**
     * -------------------------------------------
     * -------------------------------------------
     * @return mixed|string
     * itwri 2022/7/7 0:14
     */
    public function getLabel():string{
        return $this->label;
    }

    /**
     * -------------------------------------------
     * -------------------------------------------
     * @return array
     * itwri 2022/7/7 0:15
     */
    public static function labels():array{
        return self::$labels;
    }
}
