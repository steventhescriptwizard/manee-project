<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessNotification extends Notification
{
    use Queueable;

    public function __construct(public $order, public $amount)
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
            'title' => 'Pembayaran Berhasil',
            'message' => "Berhasil melakukan pembayaran dengan nominal Rp " . number_format($this->amount, 0, ',', '.') . " untuk pesanan {$this->order->order_number}.",
            'action_url' => route('customer.orders.show', $this->order->id),
            'type' => 'payment_success'
        ];
    }
}
