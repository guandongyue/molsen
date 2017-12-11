<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

use App\Article;
use App\Master;

class ArticleController extends Controller
{
    public function list(Request $request)
    {
        $datas = Article::orderBy('id', 'desc')->get();


        $masterDict = Cache::get('masterDict');

        foreach ($datas as $key => $value) {
            $datas[$key]->tags = $value->getTags($masterDict);
        }

        return view('admin.article', ['datas'=>$datas]);
    }

    public function edit(Request $request)
    {
        $id = intval($request->id);
        if ($id>0) {
            $data = Article::where('id', '=', $request->id)->first();
        } else {
            $data = new Article;
        }

        $tags = Master::select()->where('pid', '=', 1)->orderBy('id', 'desc')->get();
        $data->tags = Redis::smembers("art:{$data->id}:tag");

        return view('admin.articleEdit', ['data'=>$data, 'tags'=>$tags]);
    }

    public function save(Request $request)
    {
        if($request->title=='') return ['status'=>0, 'msg'=>'名称不能为空.'];

        $data = Article::updateOrCreate(
            ['id'=>$request->editId], 
            ['title'=>$request->title, 'note'=>$request->note, 'tags'=>$request->tags, 'status'=>$request->status]
        );

        return ['status'=>1, 'msg'=>'successful.', 'param'=>['id'=>$data->id, 'title'=>$data->title]];
    }

    public function delete(Request $request)
    {
        $data = Article::find($request->id);
        $data->delete();
        return ['status'=>1, 'msg'=>"{$data->title} 已从系统删除。", []];
    }
}
