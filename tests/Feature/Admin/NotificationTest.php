<?php

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

test('admin can mark all notifications as read', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    
    // Create some notifications for the admin
    // Note: Laravel's DatabaseNotification corresponds to the 'notifications' table
    for ($i = 0; $i < 3; $i++) {
        $admin->notifications()->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'type' => 'App\Notifications\TestNotification',
            'data' => ['message' => 'Test notification ' . $i, 'order_number' => 'MN-123'],
        ]);
    }

    $this->assertEquals(3, $admin->unreadNotifications()->count());

    $response = $this->actingAs($admin)
        ->from(route('admin.dashboard'))
        ->post(route('admin.notifications.markAllAsRead'));

    $response->assertRedirect(route('admin.dashboard'));
    $response->assertSessionHas('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    
    $admin->refresh();
    $this->assertEquals(0, $admin->unreadNotifications()->count());
});
