<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedisKey extends Model
{
    // art:{id}:tag 文章对应的标签集合
    // tag:{id}:art 标签对应的文章集合
    // tag:zset 标签包含文章数量排行榜
    // art:visitor:zset 文章访问数量排行榜
    // visitor:{sessionid} 文章访问时间及过期
    // history:{sessionid}:zset 文章访问历史及时间戳
    const ARTICLE = 'art';
    const TAGS = 'tag';
    const VISITOR = 'visitor';
    const HISTORY = 'history';

    const ARTICLE_VISITOR = 'art:visitor:zset';
    const TAGS_ARTICLE_NUM = 'tags:zset';
}
