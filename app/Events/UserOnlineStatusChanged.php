<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserOnlineStatusChanged implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(
        public string $role,   
        public int $user_id,
        public string $name,
        public bool $is_online
    ) {}

    public function broadcastOn(): Channel
    {
        // 👑 ONE channel for admins
        return new Channel('admins-channel');
    }

    public function broadcastAs(): string
    {
        return 'user.status.changed';
    }

    public function broadcastWith(): array
    {
        return [
            'role'      => $this->role,
            'user_id'   => $this->user_id,
            'name'      => $this->name,
            'is_online' => $this->is_online,
        ];
    }
}
