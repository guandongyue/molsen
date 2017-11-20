<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Category;

class BlogController extends Controller
{
    public $categorys;

    public function __construct()
    {
        $this->categorys = Category::select('id', 'name')->orderBy('id', 'desc')->get();
    }

    //
    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->get();
        return view('blog', ['articles'=>$articles, 'categorys'=>$this->categorys]);
    }

    public function view(Request $request)
    {
        $article = Article::where('id', '=', $request->id)->first();
        return view('article.view', ['article'=>$article, 'categorys'=>$this->categorys]);
    }

    public function list(Request $request)
    {
        $article = Article::where('category', '=', $request->categoryid)->select('id', 'category', 'title', 'status')->orderBy('id', 'desc')->get();
        return ['status'=>1, 'msg'=>'successful.', 'data'=>$article];
    }

    public function edit(Request $request)
    {
        $article = Article::where('id', '=', $request->id)->first();
        $articles = Article::where('category', '=', $article->category)->select('id', 'category', 'title', 'status')->orderBy('id', 'desc')->get();
        return view('article.edit', ['article'=>$article, 'articles'=>$articles, 'categorys'=>$this->categorys]);
    }

    public function delete(Request $request)
    {
        Article::destroy($request->id);
        return redirect('/');
    }

    public function save(Request $request)
    {
        $article = Article::updateOrCreate(
            ['title'=>$request->title], 
            ['title'=>$request->title, 'category'=>$request->category, 'note'=>$request->note, 'status'=>$request->status]
        );
        return ['status'=>1, 'msg'=>'successful.', 'param'=>['id'=>$article->id, 'title'=>$article->title]];
    }
}
