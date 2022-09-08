<?php

namespace App\Http\Controllers\Users;

use App\Enums\ClientTypeEnum;
use App\Exceptions\ApiException;
use App\Exceptions\ErrorCode\AuthError;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    protected $auth;

    public function __construct(UserRepository $repository, JWTAuth $auth)
    {
        $this->repository = $repository;
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     * @author zzp
     * @date 2022/9/1
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        /**
         * @var User
         */
        $user = $this->repository->findWhere(['username'=>$credentials['username']??''])->first();
        if(empty($user)){
            throw new ApiException(AuthError::USER_NOT_EXISTS());
        }

        if(!password_verify($credentials['password'],$user->password)){
            throw new ApiException(AuthError::PASSWORD_WRONG());
        }
        $user->setJWTCustomClaims(['client'=>ClientTypeEnum::USER]);
        $this->auth->factory()->setTTL(30);
        $user->remember_token = $token = $this->auth->fromSubject($user);

        $user->save();

        return $this->success([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->auth->factory()->getTTL() * 60,
        ]);
    }

    public function info(){
        return $this->success($this->auth->user());
    }
}
