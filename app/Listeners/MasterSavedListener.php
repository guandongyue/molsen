<?php

namespace App\Listeners;

use App\Events\MasterSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $event->master->setCache();
        $event->master->updateRedisTags();
    }
}
