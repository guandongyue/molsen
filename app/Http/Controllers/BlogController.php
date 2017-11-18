<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class BlogController extends Controller
{
    //
    public function index()
    {
        $articles = Article::find(1)->orderBy('id', 'desc')->get();
        return view('blog', ['articles'=>$articles, 'categorys'=>\App\Article::CATEGORYS]);
    }

    public function view(Request $request)
    {
        $article = Article::where('id', '=', $request->id)->first();
        return view('article.view', ['article'=>$article, 'categorys'=>\App\Article::CATEGORYS]);
    }

    public function edit(Request $request)
    {
        $article = Article::where('id', '=', $request->id)->first();
        return view('article.edit', ['article'=>$article, 'categorys'=>\App\Article::CATEGORYS]);
    }
}
