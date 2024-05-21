<?php

namespace App\Listeners;

use App\Events\OurExampleEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OurExampleListener
{
    /**
     * Create the event listener.
     */
    public function __construct($theEvent)
    {
        //
        $this->username = $theEvent['username'];
        $this->action = $theEvent['action'];
    }

    /**
     * Handle the event.
     */
    public function handle(OurExampleEvent $event): void
    {
        //
        Log::debug('Our custom event and listener worked');
    }
}
