<?php

namespace App\Listeners;

use App\Events\MasterSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\RedisKey;
use App\Lua;

class MasterSavedListener
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
     * @param  MasterSaved  $event
     * @return void
     */
    public function handle(MasterSaved $event)
    {
        $master = $event->master->select()->get();

        Redis::eval(Lua::TAGS_UPDATE, 0, 0);

        $tagsName = $master->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->toArray();
        Cache::forever('masterDict', $tagsName);
    }
}
