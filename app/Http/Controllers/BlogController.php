<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\Article;
use App\Master;
use App\RedisKey;
use App\Events\ArticleView;

class BlogController extends Controller
{
    public $categorys;

    public function __construct()
    {
        $this->categorys = Master::select('id', 'name')->where('pid', '=', '1')->orderBy('id', 'desc')->get();
    }

    //
    public function index(Request $request)
    {
        $masterDict = Cache::get('masterDict');
        $tagid = intval(array_search($request->tag, $masterDict));

        $condition[] = ['status', '=', '1'];
        if ($tagid>0) {
            $articles = Redis::smembers(RedisKey::TAGS.$tagid.RedisKey::ARTICLE);
            if (count($articles) > 0) {
                $articles = Article::where($condition)->wherein('id', $articles)->orderBy('id', 'desc')->paginate(10);
            } else {
                $articles = Article::where('id', '=', '0')->paginate(10);
            }
        } else {
            $articles = Article::where($condition)->orderBy('id', 'desc')->paginate(10);
        }

        foreach ($articles as $key => $value) {
            $articles[$key]->tags = $value->getTags($masterDict);
        }

        return view('blog', ['articles'=>$articles, 'categorys'=>$this->categorys, 'tags'=>Redis::zrevrange(RedisKey::TAGS_ARTICLE_NUM, 0, -1, 'withscores'), 'master'=>$masterDict]);
    }

    public function view(Request $request)
    {
        $article = Article::where('id', '=', $request->id)->first();

        $masterDict = Cache::get('masterDict');

        Event::fire(new ArticleView($request));

        $article->tags = $article->getTags($masterDict);

        return view('article.view', ['article'=>$article, 'categorys'=>$this->categorys, 'tags'=>Redis::zrevrange(RedisKey::TAGS_ARTICLE_NUM, 0, -1, 'withscores'), 'master'=>$masterDict]);
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
