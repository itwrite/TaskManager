<?php

namespace App\Traits;

trait JsonResponseTrait
{


    /**
     * @param string $message
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     * @author zzp
     * @date 2022/5/23
     */
    protected function success($data = null, string $message='success', array $headers = []){
        $result = [
            'code'=>200,
            'data'=>$data,
            'message'=>$message
        ];
        return response()->json($result,200,$headers);
    }

    /**
     * @param $message
     * @param int $errorCode
     * @param int $httpStatus
     * @return \Illuminate\Http\JsonResponse
     * @author zzp
     * @date 2022/5/23
     */
    protected function error($message,int $errorCode = -1,int $httpStatus = 401){
        $result = [
            'code'=>$errorCode,
            'message'=>$message
        ];
        return response()->json($result,$httpStatus);
    }
}
