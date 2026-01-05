<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Events\OrderPaidEvent;

class MidtransNotificationController extends Controller
{
    /**
     * Handle incoming webhook notification from Midtrans.
     * URL: POST /midtrans/notification
     */
    public function handle(Request $request)
    {
        // 1. Ambil data notifikasi
        $payload = $request->all();

        // Log untuk debugging
        Log::info('Midtrans Notification Received', $payload);

        // 2. Extract Data Penting
        $orderId           = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $paymentType       = $payload['payment_type'] ?? null;
        $statusCode        = $payload['status_code'] ?? null;
        $grossAmount       = $payload['gross_amount'] ?? null;
        $signatureKey      = $payload['signature_key'] ?? null;
        $fraudStatus       = $payload['fraud_status'] ?? null;
        $transactionId     = $payload['transaction_id'] ?? null;

        // 3. Validasi Field Wajib
        if (!$orderId || !$transactionStatus || !$signatureKey) {
            Log::warning('Midtrans Notification: Missing required fields', $payload);
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // 4. VALIDASI SIGNATURE KEY
        $serverKey = config('midtrans.server_key');
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans Notification: Invalid signature', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 5. Cari Order di Database
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::warning("Midtrans Notification: Order not found", ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // 6. IDEMPOTENCY CHECK
        // Jika order sudah dalam status final, jangan proses lagi.
        if (in_array($order->status, ['processing', 'shipped', 'delivered', 'cancelled'])) {
            return response()->json(['message' => 'Order already processed'], 200);
        }

        // 7. Update Data Tambahan di Payment Record
        $payment = $order->payment;
        if ($payment) {
            $payment->update([
                'midtrans_transaction_id' => $transactionId,
                'payment_type'            => $paymentType,
                'raw_response'            => json_encode($payload),
            ]);
        }

        // 8. MAPPING STATUS TRANSAKSI MENGGUNAKAN TRANSACTION
        DB::transaction(function () use ($transactionStatus, $fraudStatus, $order, $payment) {
            switch ($transactionStatus) {
                case 'capture':
                    if ($fraudStatus === 'challenge') {
                        $this->handlePending($order, $payment, 'Menunggu review fraud');
                    } else {
                        $this->handleSuccess($order, $payment);
                    }
                    break;

                case 'settlement':
                    $this->handleSuccess($order, $payment);
                    break;

                case 'pending':
                    $this->handlePending($order, $payment, 'Menunggu pembayaran');
                    break;

                case 'deny':
                    $this->handleFailed($order, $payment, 'Pembayaran ditolak');
                    break;

                case 'expire':
                case 'cancel':
                    // LOGIKA RESTOCK (Hanya jika belum cancelled)
                    if ($order->status !== 'cancelled') {
                        foreach ($order->items as $item) {
                            // Menggunakan optional chaining untuk mencegah error jika produk dihapus
                            $item->product?->increment('stock', $item->quantity);
                        }

                        $order->update([
                            'status' => 'cancelled',
                            // Jika Anda punya kolom payment_status di tabel orders:
                            'payment_status' => 'failed'
                        ]);

                        if ($payment) {
                            $payment->update(['status' => 'failed']);
                        }

                        Log::info("Order {$order->order_number} restocked via {$transactionStatus}");
                    }
                    break;

                case 'refund':
                case 'partial_refund':
                    $this->handleRefund($order, $payment);
                    break;

                default:
                    Log::info("Midtrans Notification: Unknown status", ['status' => $transactionStatus]);
            }
        });

        return response()->json(['message' => 'Notification processed'], 200);
    }

    /**
     * Handle pembayaran sukses.
     */
    protected function handleSuccess(Order $order, ?Payment $payment): void
    {
        $order->update(['status' => 'processing']);

        if ($payment) {
            $payment->update([
                'status'  => 'success',
                'paid_at' => now(),
            ]);
        }
    }

    /**
     * Handle pembayaran pending.
     */
    protected function handlePending(Order $order, ?Payment $payment, string $message = ''): void
    {
        if ($payment) {
            $payment->update(['status' => 'pending']);
        }
    }

    /**
     * Handle pembayaran gagal secara umum (misal: deny).
     */
    protected function handleFailed(Order $order, ?Payment $payment, string $reason = ''): void
    {
        $order->update(['status' => 'cancelled']);

        if ($payment) {
            $payment->update(['status' => 'failed']);
        }

        // Restock umum jika belum diproses
        foreach ($order->items as $item) {
            $item->product?->increment('stock', $item->quantity);
        }
    }

    /**
     * Handle refund.
     */
    protected function handleRefund(Order $order, ?Payment $payment): void
    {
        if ($payment) {
            $payment->update(['status' => 'refunded']);
        }
    }
    private function setSuccess(Order $order)
{
    $order->update([...]);

    // Fire & Forget
    event(new OrderPaidEvent($order));
}
}
