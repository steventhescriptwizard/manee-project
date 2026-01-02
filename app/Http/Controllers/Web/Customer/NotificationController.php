<?php

namespace App\Http\Controllers\Web\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('filter', 'ALL');

        $query = $user->notifications();

        if ($filter === 'ORDER') {
            $query->whereIn('type', [
                'App\Notifications\CustomerOrderCreateNotification', 
                'App\Notifications\OrderShippedNotification',
                'App\Notifications\OrderOutForDeliveryNotification'
            ]);
        } elseif ($filter === 'FINANCE') {
            $query->whereIn('type', [
                'App\Notifications\PaymentSuccessNotification'
            ]);
        } elseif ($filter === 'PROMO') {
            $query->whereIn('type', [
                'App\Notifications\PromoNotification', 
                'App\Notifications\SystemNotification'
            ]);
        }

        $notifications = $query->paginate(10);

        return view('web.customer.notifications', compact('notifications', 'filter'));
    }

    public function markRead($id)
    {
        $user = Auth::user();
        
        if ($id === 'all') {
            $user->unreadNotifications->markAsRead();
            return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
        }

        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('success', 'Notifikasi ditandai sebagai dibaca.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if ($id === 'all') {
            $user->notifications()->delete();
            return back()->with('success', 'Semua notifikasi berhasil dihapus.');
        }

        $notification = $user->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
