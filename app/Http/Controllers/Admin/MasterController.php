<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Master;

class MasterController extends Controller
{
    public function list(Request $request)
    {
        $datas = Master::select()->orderBy('id', 'desc')->get();
        $tree = Master::tree();
        return view('admin.master', ['datas'=>$datas, 'tree'=>Master::buildTreeView($tree, $request->typeid)]);
    }

    public function edit(Request $request)
    {
        $id = intval($request->id);
        $data = [];
        if ($id>0) $data = Master::where('id', '=', $request->id)->first();

        $datas = Master::select('id', 'name')->orderBy('id', 'desc')->get();

        return view('admin.masterEdit', ['data'=>$data, 'datas'=>$datas]);
    }

    public function save(Request $request)
    {
        if($request->name=='') return ['status'=>0, 'msg'=>'名称不能为空.'];

        $data = Master::updateOrCreate(
            ['id'=>$request->editId], 
            ['pid'=>intval($request->pid), 'name'=>$request->name, 'key'=>$request->key, 'value'=>$request->value]
        );
        return ['status'=>1, 'msg'=>'successful.', 'param'=>['id'=>$data->id, 'name'=>$data->name]];
    }
}
