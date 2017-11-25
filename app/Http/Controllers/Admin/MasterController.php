<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Master;

class MasterController extends Controller
{
    public function list(Request $request)
    {
        $datas = Master::select('id', 'name')->orderBy('id', 'desc')->get();
        return view('admin.master', ['datas'=>$datas]);
    }

    public function edit(Request $request)
    {
        $category = Master::where('id', '=', $request->id)->first();
        $category->name = $request->name;
        $category->save();
        return view('admin.masterEdit', ['articles'=>1]);
    }
}
