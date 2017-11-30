<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Article;
use App\Master;

class ArticleController extends Controller
{
    public function list(Request $request)
    {
        $datas = Article::orderBy('id', 'desc')->get();
        return view('admin.article', ['datas'=>$datas]);
    }

    public function edit(Request $request)
    {
        $id = intval($request->id);
        $data = [];
        if ($id>0) $data = Master::where('id', '=', $request->id)->first();

        $tags = Master::select()->where('pid', '=', 1)->orderBy('id', 'desc')->get();

        return view('admin.articleEdit', ['data'=>$data, 'tags'=>$tags]);
    }
}
