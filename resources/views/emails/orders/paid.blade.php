<?php
// app/Mail/OrderPaid.php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPaid extends Mailable
{
    // Trait Queueable: Memungkinkan email ini dikirim melalui antrian (Queue)
    // Trait SerializesModels: Penting saat passing Model Order ke Queue.
    // Laravel hanya akan menyimpan ID Order di Queue, lalu mengambil ulang datanya saat Job diproses.
    use Queueable, SerializesModels;

    // Visibility PUBLIC agar bisa diakses langsung di file VIEW blade.
    // Tidak perlu passing via with() di method content.
    public function __construct(
        public Order $order
    ) {}

    /**
     * Definisi Subjek dan Pengirim Email.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembayaran Diterima - Order #' . $this->order->order_number,
        );
    }

    /**
     * Definisi Isi Konten Email (View).
     */
    public function content(): Content
    {
        return new Content(
            // Menggunakan Markdown view
            // Lokasi: resources/views/emails/orders/paid.blade.php
            markdown: 'emails.orders.paid',
        );
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran Berhasil</title>
    <style>
        /* Gaya dasar ala Bootstrap 5 */
        body { font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8f9fa; color: #212529; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; margin-top: 20px; border: 1px solid #dee2e6; }
        .header { background-color: #0d6efd; color: white; padding: 20px; text-align: center; }
        .content { padding: 30px; }
        .table { width: 100%; margin-bottom: 1rem; color: #212529; border-collapse: collapse; }
        .table th, .table td { padding: 0.75rem; border-top: 1px solid #dee2e6; text-align: left; }
        .table thead th { border-bottom: 2px solid #dee2e6; background-color: #f8f9fa; }
        .btn { display: inline-block; font-weight: 400; color: #fff; text-align: center; vertical-align: middle; cursor: pointer; background-color: #0d6efd; border: 1px solid #0d6efd; padding: 0.375rem 0.75rem; font-size: 1rem; line-height: 1.5; border-radius: 0.25rem; text-decoration: none; margin-top: 15px; }
        .footer { background-color: #f8f9fa; padding: 20px; text-align: center; font-size: 0.875rem; color: #6c757d; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">{{ config('app.name') }}</h2>
        </div>

        <div class="content">
            <h3>Halo, {{ $order->user->name }}</h3>
            <p>Terima kasih! Pembayaran untuk pesanan <span class="fw-bold">#{{ $order->order_number }}</span> telah kami terima.</p>
            <p>Kami sedang memproses pesanan Anda.</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align: center;">Qty</th>
                        <th class="text-end">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr class="fw-bold">
                        <td colspan="2" class="text-end">Total</td>
                        <td class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <div style="text-align: center;">
                <a href="{{ route('orders.show', $order) }}" class="btn">
                    Lihat Detail Pesanan
                </a>
            </div>

            <p style="margin-top: 30px;">Jika ada pertanyaan, silakan balas email ini.</p>
            <p>Salam,<br><strong>{{ config('app.name') }}</strong></p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
