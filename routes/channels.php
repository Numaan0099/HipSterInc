<?php

use Illuminate\Support\Facades\Broadcast;

use App\Events\UserOnlineStatusChanged;

Broadcast::channel('presence-customers', function () {
    if (!auth('customer')->check()) {
        return false;
    }

    $customer = auth('customer')->user();

    // 🔥 notify admins
    broadcast(new UserOnlineStatusChanged(
        role: 'customer',
        user_id: $customer->customer_id,
        name: $customer->customer_name,
        is_online: true
    ))->toOthers();

    return [
        'id'   => $customer->customer_id,
        'name' => $customer->customer_name,
    ];
});


Broadcast::channel('presence-admins', function () {
    if (!auth('admin')->check()) {
        return false;
    }

    $admin = auth('admin')->user();

    broadcast(new UserOnlineStatusChanged(
        role: 'admin',
        user_id: $admin->admin_id,
        name: $admin->admin_name,
        is_online: true
    ))->toOthers();

    return [
        'id'   => $admin->admin_id,
        'name' => $admin->admin_name,
    ];
});

