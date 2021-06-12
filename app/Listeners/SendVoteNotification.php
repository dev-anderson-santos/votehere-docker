<?php

namespace App\Listeners;

use App\Events\NewVote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVoteNotification
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
     * @param  NewVote  $event
     * @return void
     */
    public function handle(NewVote $event)
    {
        //
    }
}
