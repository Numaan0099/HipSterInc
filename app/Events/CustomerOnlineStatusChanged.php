<?php

namespace App\Events;

use App\Models\Customer;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CustomerOnlineStatusChanged implements ShouldBroadcast
{
    use SerializesModels;

    public function __construct(
        public Customer $customer,
        public bool $isOnline
    ) {}

    public function broadcastOn(): Channel
    {
        // 🔒 Admin-only channel
        return new Channel('admins-channel');
    }

    public function broadcastAs(): string
    {
        return 'customer.status.changed';
    }

    public function broadcastWith(): array
    {
        return [
            'customer_id'   => $this->customer->customer_id,
            'customer_name' => $this->customer->customer_name,
            'is_online'     => $this->isOnline,
        ];
    }
}
