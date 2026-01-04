<?php

namespace App\Jobs;

use App\Mail\MarketingBlast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendMarketingEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messageContent; // Renamed to avoid collision with standard properties if any
    protected $subject;
    protected $audience;

    /**
     * Create a new job instance.
     */
    public function __construct($subject, $content, $audience)
    {
        $this->subject = $subject;
        $this->messageContent = $content;
        $this->audience = $audience;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Simple logic for audience selection
        $query = User::where('role', 'customer');
        
        if ($this->audience === 'vip') {
            // VIP: Customers with more than 5 orders
            $query->has('orders', '>=', 5);
        } elseif ($this->audience === 'new') {
            // New: Signed up in last 30 days
            $query->where('created_at', '>=', now()->subDays(30));
        }

        $users = $query->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new MarketingBlast($this->subject, $this->messageContent));
        }
    }
}
