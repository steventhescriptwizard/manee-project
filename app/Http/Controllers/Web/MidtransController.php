<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_number', $request->order_id)->first();
        
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $request->transaction_status;
        $type = $request->payment_type;
        $fraud = $request->fraud_status;

        // Map Midtrans payment type to readable format
        $paymentMethodMap = [
            'credit_card' => 'Midtrans - Credit Card',
            'bank_transfer' => 'Midtrans - Bank Transfer',
            'echannel' => 'Midtrans - Mandiri Bill',
            'bca_va' => 'Midtrans - BCA Virtual Account',
            'bni_va' => 'Midtrans - BNI Virtual Account',
            'bri_va' => 'Midtrans - BRI Virtual Account',
            'permata_va' => 'Midtrans - Permata Virtual Account',
            'other_va' => 'Midtrans - Virtual Account',
            'gopay' => 'Midtrans - GoPay',
            'shopeepay' => 'Midtrans - ShopeePay',
            'qris' => 'Midtrans - QRIS',
            'cstore' => 'Midtrans - Convenience Store',
            'akulaku' => 'Midtrans - Akulaku',
        ];

        $paymentMethod = $paymentMethodMap[$type] ?? 'Midtrans - ' . ucwords(str_replace('_', ' ', $type));

        if ($transactionStatus == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->update([
                        'payment_status' => 'unpaid', 
                        'status' => 'pending',
                        'payment_method' => $paymentMethod
                    ]);
                } else {
                    $order->update([
                        'payment_status' => 'paid', 
                        'status' => 'processing',
                        'payment_method' => $paymentMethod
                    ]);

                    // Notify Customer
                    $order->user->notify(new \App\Notifications\PaymentSuccessNotification($order, $request->gross_amount));
                }
            }
        } else if ($transactionStatus == 'settlement') {
            $order->update([
                'payment_status' => 'paid', 
                'status' => 'processing',
                'payment_method' => $paymentMethod
            ]);
            
            // Notify Customer
            $order->user->notify(new \App\Notifications\PaymentSuccessNotification($order, $request->gross_amount));
        } else if ($transactionStatus == 'pending') {
            $order->update([
                'payment_status' => 'unpaid', 
                'status' => 'pending',
                'payment_method' => $paymentMethod
            ]);
        } else if ($transactionStatus == 'deny') {
            $order->update([
                'payment_status' => 'unpaid', 
                'status' => 'cancelled',
                'payment_method' => $paymentMethod
            ]);
        } else if ($transactionStatus == 'expire') {
            $order->update([
                'payment_status' => 'unpaid', 
                'status' => 'cancelled',
                'payment_method' => $paymentMethod
            ]);
        } else if ($transactionStatus == 'cancel') {
            $order->update([
                'payment_status' => 'unpaid', 
                'status' => 'cancelled',
                'payment_method' => $paymentMethod
            ]);
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
