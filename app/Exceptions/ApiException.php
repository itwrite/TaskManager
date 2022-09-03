<?php

namespace App\Exceptions;

use App\Exceptions\ErrorCode\ErrorCode;
use Exception;

class ApiException extends Exception
{
    protected $statusCode;

    /**
     * @param ErrorCode|string $message
     * @param int|array $code
     */
    public function __construct($message, $code = -1)
    {
        if($message instanceof ErrorCode){
            $code = $message->getValue();
            $message = $message->getMessage();
            if(is_array($code)){
                $params = $code;
                array_unshift($params,$message);
                $message = call_user_func_array('sprintf',$params);
            }
        }
        parent::__construct($message,$code);
    }

    /**
     * @return mixed
     * @author zzp
     * @date 2022/7/8
     */
    protected function getStatusCode(){
        return $this->statusCode;
    }
}
