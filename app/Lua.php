<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RedisKey;

class Lua extends Model
{
    const TAGS_UPDATE = <<<EOT
local result = {}
local tagKeys = redis.call('keys', 'tag:*:art')
for i, key in pairs(tagKeys) do
    redis.call('zadd', 'tags:zset', redis.call('scard', key), string.match(key, "(%d+)"))
end
return true
EOT;
}
