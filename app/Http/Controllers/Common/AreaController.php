<?php

namespace App\Http\Controllers\Common;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Exceptions\ErrorCode\SystemError;
use App\Http\Requests\AreaCreateRequest;
use App\Http\Requests\AreaUpdateRequest;
use App\Repositories\AreaRepository;
use App\Validators\AreaValidator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use function app;
use function redirect;
use function request;
use function response;
use function view;

/**
 * Class AreasController.
 *
 * @package namespace App\Http\Controllers;
 */
class AreaController extends Controller
{
    /**
     * @var AreaRepository
     */
    protected $repository;

    /**
     * @var AreaValidator
     */
    protected $validator;

    /**
     * AreasController constructor.
     *
     * @param AreaRepository $repository
     * @param AreaValidator $validator
     */
    public function __construct(AreaRepository $repository, AreaValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * @return JsonResponse
     * @throws ApiException
     * @author zzp
     * @date 2022/6/15
     */
    public function lists(){
        try {
            Log::info('查询1：'.microtime(true));
            $list = $this->repository->getChinaData(true);
            Log::info('查询2：'.microtime(true));
            return $this->success($list);
        }catch (\Exception $exception){
            throw new ApiException(SystemError::Error());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @author zzp
     * @date 2022/6/15
     */
    public function detail(Request $request){
        try {
            $id = $request->get('id');
            $area = $this->repository->getDetail($id);
            return $this->success($area);
        }catch (\Exception $exception){
            throw new ApiException(SystemError::Error());
        }
    }
}
