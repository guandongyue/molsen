<?php

namespace App\Listeners;

use App\Events\ArticleSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class ArticleListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ArticleSaved  $event
     * @return void
     */
    public function handle(ArticleSaved $event)
    {
        // print_r($event->article->note);
        // 获取旧数据方法
        // print_r($event->article->getOriginal()['note']);

        $data = & $event->article;

        $oldTags = Redis::smembers("art:{$data->id}:tag");
        $newTags = explode(',', $data->tags);
        $delTags = array_diff($oldTags, $newTags);
        Redis::pipeline(function ($pipe) use ($data, $newTags, $delTags) {
            $pipe->sadd("art:{$data->id}:tag", ...$newTags);
            $pipe->srem("art:{$data->id}:tag", ...$delTags);
            foreach ($delTags as $key => $value) {
                $pipe->srem("tag:{$value}:art", $data->id);
            }
            foreach ($newTags as $key => $value) {
                $pipe->sadd("tag:{$value}:art", $data->id);
            }
        });
    }
}
