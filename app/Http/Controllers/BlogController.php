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
        $articles = Article::find(1)->select('id', 'category', 'title', 'status')->orderBy('id', 'desc')->get();
        return view('article.edit', ['article'=>$article, 'articles'=>$articles, 'categorys'=>\App\Article::CATEGORYS]);
    }

    public function save(Request $request)
    {
        // $article = Article::where('title', '=', $request->title)->first();
        // $article->note = $request->note;
        // $article->save();
        // return ['status'=>1, 'msg'=>'successful.'];


        $article = Article::updateOrCreate(
            ['title'=>$request->title], 
            ['title'=>$request->title, 'note'=>$request->note, 'status'=>$request->status]
        );
        return ['status'=>1, 'msg'=>'successful.', 'param'=>['id'=>$article->id, 'title'=>$article->title]];
    }
}
