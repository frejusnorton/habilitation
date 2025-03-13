<?php

namespace App\Listeners;

use App\Events\UserActivity;
use App\Models\LogActivity;
use App\Models\User;
use App\Models\UserActivity as ModelsUserActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

   /**
     * Handle the event.
     *
     * @param UserActivity $event
     * @return void
     */
    public function handle(UserActivity $event)
    {

        LogActivity::create([
            'user' => $event->user->id,
            'action' => $event->activity,
        ]);
    }
}
