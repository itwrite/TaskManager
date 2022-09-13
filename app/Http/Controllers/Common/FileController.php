<?php

namespace App\Http\Controllers\Common;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Exceptions\ErrorCode\UploadError;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;

class FileController extends Controller
{
    const UPLOAD_TYPE_IMAGE = 'image';
    const UPLOAD_TYPE_VIDEO = 'video';

    /**
     * @var ImageService
     */
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @author zzp
     * @date 2022/7/12
     */
    public function uploadOne(Request $request){
        $type = $request->get('type',self::UPLOAD_TYPE_IMAGE);

        $config = config('upload.'.$type,[]);

        /**
         * 校验数据
         */
        $request->validate([
            'file'=>'file|max:'.Arr::get($config,'size_limit',0),//5Mb(这验证的单位是kb,5mb即5120kb)
        ]);

        if(!$request->hasFile('file')){
            throw new ApiException(UploadError::INVALID_PARAMS(),json_encode($request->files->all()));
        }

        $file = $request->file('file');

        if(!$file->isValid()){
            throw new ApiException(UploadError::INVALID_FILE());
        }

        /**
         * 接口接授的类型
         */
        if(!in_array($type,array_keys(config('upload',[])))){
            throw new ApiException(UploadError::INVALID_TYPE());
        }

        if($type == self::UPLOAD_TYPE_IMAGE){
            $allow_extensions = Arr::get($config,'allow_extensions');
            if(!empty($allow_extensions) &&!in_array(strtolower($file->getClientOriginalExtension()),$allow_extensions)){
                throw new ExtensionFileException('只能上传'.implode(',',$allow_extensions)."格式的文件");
            }
        }
        try {
            $path = $file->storePublicly('uploads/'.date('Ymd').'/'.$request->user()->id);
            $fileRealPath = Storage::path($path);
            $compressConfig = Arr::get($config,'compress',[]);
            /**
             * 图片压缩处理
             */
            if($type == self::UPLOAD_TYPE_IMAGE){
                if(strtolower($file->getClientOriginalExtension()) != 'gif'){
                    $this->imageService->compress($fileRealPath,$compressConfig);
                }
            }

            return $this->success(['path'=>$path,'extension'=>$file->getClientOriginalExtension(),'url'=>Storage::url($path)]);
        }catch (\Exception $exception){
            return $this->error($exception->getMessage());
        }
    }
}
