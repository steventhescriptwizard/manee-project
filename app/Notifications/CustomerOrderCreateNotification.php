<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerOrderCreateNotification extends Notification
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
            'title' => 'Pesanan Berhasil Dibuat',
            'message' => "Pesanan Anda dengan nomor pesanan {$this->order->order_number} telah berhasil dibuat. Klik disini untuk melihat detail pesanan Anda.",
            'action_url' => route('customer.orders.show', $this->order->id),
            'type' => 'order_created'
        ];
    }
}
