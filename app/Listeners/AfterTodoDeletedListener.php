<?php

namespace App\Listeners;

use App\Events\AfterTodoDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class AfterTodoDeletedListener
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
     * @param  AfterTodoDeleted  $event
     * @return void
     */
    public function handle(AfterTodoDeleted $event)
    {
        Log::info("delete todo {$event->id}");
    }
}
