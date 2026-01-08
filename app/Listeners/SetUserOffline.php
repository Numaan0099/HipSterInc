<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Events\CustomerOnlineStatusChanged;

class SetUserOffline
{
    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        if ($event->guard === 'admin' && $event->user) {
            $event->user->update(['is_online' => false]);

        }

        if ($event->guard === 'customer' && $event->user) {
            $event->user->update(['is_online' => false]);
            broadcast(new CustomerOnlineStatusChanged($event->user));

        }
    }
}
