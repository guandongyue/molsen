<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function add(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->save();
        return ['status'=>1, 'msg'=>'successful.'];
    }

    public function edit(Request $request)
    {
        $category = Category::where('id', '=', $request->id)->first();
        $category->name = $request->name;
        $category->save();
        return ['status'=>1, 'msg'=>'successful.'];
    }
}
