<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function list(Request $request)
    {
        return view('admin.article', ['articles'=>1]);
    }

    public function edit(Request $request)
    {
        return view('admin.articleEdit', ['articles'=>1]);
    }
}
