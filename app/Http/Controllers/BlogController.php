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
        $categorys = \APP\Article::CATEGORYS;
        return view('blog', ['articles'=>$articles, 'categorys'=>$categorys]);
    }
}
