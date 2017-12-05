<?php

namespace App\Listeners;

use App\Events\MasterSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;

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
        $tagsName = $event->master->select()->get()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->toArray();
        Cache::forever('masterDict', $tagsName);
    }
}
