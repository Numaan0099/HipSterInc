<?php

namespace App\Events;

use App\Models\Admin;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class AdminOnlineStatusChanged implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(
        public Admin $admin
    ) {}

    public function broadcastOn()
    {
        return new Channel('admin-status');
    }

    public function broadcastAs()
    {
        return 'admin.status.changed';
    }

    public function broadcastWith()
    {
        return [
            'admin_id' => $this->admin->admin_id,
            'admin_name' => $this->admin->admin_name,
            'is_online' => $this->admin->is_online,
        ];
    }
}
