<?php

namespace App;

use App\RedisKey;
use App\Events\ArticleSaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Article extends Model
{
    const CREATED_AT = 'intime';
    const UPDATED_AT = 'uptime';

    //
    const CATEGORYS = [1=>'服务端', '前端', '服务器', '客户端'];

    // protected $fillable = ['title'];
    protected $guarded = ['id'];

    /**
     * 模型的事件映射。
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => ArticleSaved::class,
    ];

    public function getTags(Array $dict)
    {
        $result = [];
        $tags = Redis::smembers(RedisKey::ARTICLE.":{$this->id}:".RedisKey::TAGS);
        if (!empty($tags)) {
            foreach ($tags as $k => $v) {
                if ($v == '') continue;
                $result[$v] = $dict[$v];
            }
        }

        return $result;
    }

    public function getVisitor()
    {
        return Redis::zscore(RedisKey::ARTICLE.":".RedisKey::VISITOR.":zset", $this->id);
    }
}
