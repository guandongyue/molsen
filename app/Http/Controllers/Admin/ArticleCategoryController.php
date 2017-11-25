<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;

class ArticleCategoryController extends Controller
{
    //
    public function list(Request $request)
    {
        $datas = Category::select('id', 'name')->orderBy('id', 'desc')->get();
        return view('admin.articleCategory', ['datas'=>$datas]);
    }

    public function edit(Request $request)
    {
        $category = Category::where('id', '=', $request->id)->first();
        $category->name = $request->name;
        $category->save();
        return view('admin.articleCategoryEdit', ['articles'=>1]);
    }
}
