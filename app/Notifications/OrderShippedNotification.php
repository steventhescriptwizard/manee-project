<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderShippedNotification extends Notification
{
    use Queueable;

    public function __construct(public $order)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pesanan Dikirim',
            'message' => "Pesanan Anda dengan nomor pesanan {$this->order->order_number} sudah dikirimkan oleh penjual. Klik di sini untuk melacak pesanan Anda.",
            'action_url' => route('order.tracking', ['order_number' => $this->order->order_number]),
            'type' => 'order_shipped'
        ];
    }
}
