<?php

namespace App\Exceptions\ErrorCode;

use MyCLabs\Enum\Enum;

abstract class ErrorCode extends Enum
{
    private $message;
    protected static $messages = [];

    public function __construct($value)
    {
        parent::__construct($value);
        $this->message = static::$messages[$this->getValue()]??"";
    }

    public function getMessage(){
        return $this->message;
    }
}
