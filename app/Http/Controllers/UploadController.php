<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    public function save(Request $request)
    {
        # 上传文件
        $path = $request->file('editormd-image-file')->store('blog');
        $url = asset("storage/{$path}");
        return ['success'=>1, 'message'=>'上传成功', 'url'=>$url];
    }
}
