<?php

namespace App\Listeners;

use App\Events\ArticleView;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;
use App\RedisKey;

class ArticleViewListener
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
     * @param  ArticleView  $event
     * @return void
     */
    public function handle(ArticleView $event)
    {
        $data['sessionid'] = $event->request->cookie('molsen_session');
        $data['articleID'] = $event->request->id;
        $data['type'] = 'article';

        Redis::pipeline(function ($pipe) use ($data) {
            // 用户访问历史记录
            $pipe->zadd(RedisKey::HISTORY.":{$data['sessionid']}:zset", time(), "{$data['type']}:{$data['articleID']}");
            // 用户访问历史记录 只保留最近30个，其他都删除
            $pipe->zremrangebyrank(RedisKey::HISTORY.":{$data['sessionid']}:zset", 0, -31);
        });
        // 检查该用户是否刚访问过
        $visitor = Redis::exists(RedisKey::VISITOR.":{$data['sessionid']}");
        if ($visitor===0) {
            Redis::pipeline(function ($pipe) use ($data) {
                // 如果16小时内未访问过，则给文章增加访客数量
                $pipe->zincrby(RedisKey::ARTICLE.":".RedisKey::VISITOR.":zset", 1, $data['articleID']);
                // 访客数量增加后，标识访客近期已访问过，16小时候过期，允许增加文章访问数量
                $pipe->setex(RedisKey::VISITOR.":{$data['sessionid']}", 57600, time());
            });
        }
    }
}
