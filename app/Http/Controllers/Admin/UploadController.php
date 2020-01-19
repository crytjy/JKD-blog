<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    /**
     * 上传文件
     *
     * @param Request $request
     * @param string $fileName
     * @param string $disk
     * @return string|void
     */
    public function uploadFile(Request $request, $fileName = 'attachment', $disk = 'public')
    {
        if ($request->hasFile($fileName)) {
            //获取文件
            $file = $request->file($fileName);
            $time = date('Ymd', time());
            // 文件是否上传成功
            if ($file->isValid()) {
                $userId = Auth::user()->id ?? 0;
                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpeg

                // 上传文件
                $filename = uniqid() . '.' . $ext;
                $dirname = $userId . '/' . $time;
                $picPath = $dirname . '/' . $filename;
                Storage::disk($disk)->makeDirectory($dirname);
                $bool = Storage::disk($disk)->put('/' . $picPath, file_get_contents($realPath));
                //判断是否创建成功
                if ($bool) {
                    return $picPath;
                }
            }
        }
        return;
    }


    /**
     * 删除文件
     *
     * @param $picPath
     * @param string $disk
     */
    public function delFile($picPath, $disk = 'public')
    {
        if (Storage::disk($disk)->exists($picPath)) {
            Storage::disk($disk)->delete($picPath);
        }
    }


    /**
     * ckeditor 图片上传
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadEditFile(Request $request)
    {
        $fileData = $request->get('upload');
        if ($fileData) {
            //获取文件
            $time = date('Ymd', time());
            $userId = Auth::user()->id ?? 0;

            // 上传文件
            $dirname = $userId . '/' . $time;
            Storage::disk('public')->makeDirectory($dirname);

            $base64_image = str_replace(' ', '+', $fileData);
            //post的数据里面，加号会被替换为空格，需要重新替换回来，如果不是post的数据，则注释掉这一行
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)) {
                //匹配成功
                if ($result[2] == 'jpeg') {
                    $image_name = uniqid() . '.jpg';
                } else {
                    $image_name = uniqid() . '.' . $result[2];
                }
                $image_file = "/{$image_name}";
                $bool = Storage::disk('public')->put('/' . $dirname . $image_file, base64_decode(str_replace($result[1], '', $base64_image)));

                //判断是否创建成功
                if ($bool) {
                    $url = Storage::disk('public')->url($dirname . $image_file);
                    return response()->json(['url' => $url], 200);
                }
            }
        }

        return response()->json(['msg' => '上传失败！'], 400);
    }


    /**
     * 远程上传
     *
     * @param $pic
     * @return string
     */
    public function remoteUploadFile($pic)
    {
        // 上传文件
        $time = date('Ymd', time());
        $info = explode('.', $pic);
        $count = count($info) - 1;
        $ext = explode('.', $pic)[$count] ?? 'jpg';
        $filename = uniqid() . '.' . $ext;
        $dirname = 'mryj/' . $time;
        $picPath = $dirname . '/' . $filename;
        Storage::disk('public')->makeDirectory($dirname);
        $bool = Storage::disk('public')->put('/' . $picPath, file_get_contents($pic));
        //判断是否创建成功
        if ($bool) {
            return $picPath;
        }
    }

}
