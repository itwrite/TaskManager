<?php


namespace App\Services;


use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;

class ImageService
{
    /**
     * -------------------------------------------
     * 图片压缩
     * -------------------------------------------
     * @param $fileRealPath
     * @param $compressConfig
     * @return \Intervention\Image\Image
     * itwri 2022/7/4 21:48
     */
    public function compress($fileRealPath,$compressConfig){
        $image = Image::make($fileRealPath);
        //如果图片的宽度超过了限制，则压缩为对应的宽度
        $triggerWidth = Arr::get($compressConfig,'trigger.width',0);
        $triggerSize = Arr::get($compressConfig,'trigger.size',0);
        if($image->extension == 'gif'){
            //gif nocompress
            return $image;
        }
        if($triggerWidth && $image->getWidth() > $triggerWidth){
            return $image->resize(Arr::get($compressConfig,'target.width',$image->getWidth()), null, function ($constraint) {
                $constraint->aspectRatio();
            })->save();
        }elseif ($triggerSize && $image->filesize() > $triggerSize){
            //
            if($image->getWidth() > $image->getHeight()){
                //如果宽>高，则处理宽
                return $image->resize(Arr::get($compressConfig,'target.width',$image->getWidth()), null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
            }else{
                //反之处理高
                return $image->resize( null,Arr::get($compressConfig,'target.height',$image->getHeight()), function ($constraint) {
                    $constraint->aspectRatio();
                })->save();
            }
        }
        return $image;
    }

    /**
     * -------------------------------------------
     * gif compress
     * -------------------------------------------
     * @param $fileRealPath
     * @param null $destinationFilename
     * @return \Intervention\Image\Image
     * itwri 2022/7/4 21:09
     */
    public function compressGif($fileRealPath,$destinationFilename = null){
        $destination_filename = $destination_filename ?? $fileRealPath;
        $img = imagecreatefromstring(file_get_contents($fileRealPath));

        imagetruecolortopalette($img, false, 16); // compress to 16 colors in gif palette (change 16 to anything between 1-256)

        imagegif($img, $destination_filename); // $destination_filename is the location on your server where you want to save the compressed gif file
        return Image::make($destination_filename);
    }
}
