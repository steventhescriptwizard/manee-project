<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class MarketingController extends Controller
{
    public function index()
    {
        // Abandoned Cart Logic:
        // A cart is considered abandoned if it has items AND hasn't been updated for at least 1 hour.
        $abandonedCarts = \App\Models\Cart::with(['user', 'items.product', 'items.variant'])
            ->whereHas('items')
            ->where('updated_at', '<', now()->subHours(1)) 
            ->latest()
            ->take(10) // Limit to 10 for display
            ->get();

        return view('admin.marketing.index', compact('abandonedCarts'));
    }

    public function sendEmailBlast(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'content' => 'required',
            'audience' => 'required',
        ]);

        // Dispatch Job to Queue
        \App\Jobs\SendMarketingEmail::dispatch($request->subject, $request->content, $request->audience);

        return back()->with('success', 'Email campaign has been queued and will be sent shortly!');
    }
}
