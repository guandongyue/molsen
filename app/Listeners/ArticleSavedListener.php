<?php

namespace App\Listeners;

use App\Events\ArticleSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;
use App\RedisKey;

class ArticleSavedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
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
        
        // 获取文章现有的标签
        $oldTags = Redis::smembers(RedisKey::ARTICLE.":{$data->id}:".RedisKey::TAGS);
        $newTags = explode(',', $data->tags);
        // 获取文章需要删除掉的标签
        $delTags = array_diff($oldTags, $newTags);
        Redis::pipeline(function ($pipe) use ($data, $newTags, $delTags) {
            // 处理文章集合
            // 增加标签
            $pipe->sadd(RedisKey::ARTICLE.":{$data->id}:".RedisKey::TAGS, ...$newTags);
            // 删除标签
            $pipe->srem(RedisKey::ARTICLE.":{$data->id}:".RedisKey::TAGS, ...$delTags);

            // 处理标签集合
            foreach ($delTags as $key => $value) {
                // 删除文章
                $pipe->srem(RedisKey::TAGS.":{$value}:".RedisKey::ARTICLE, $data->id);
            }
            foreach ($newTags as $key => $value) {
                // 增加文章
                $pipe->sadd(RedisKey::TAGS.":{$value}:".RedisKey::ARTICLE, $data->id);
            }
        });
    }
}
