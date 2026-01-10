<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pesanan Baru</title>
</head>
<body style="font-family: Arial, sans-serif">

    <h2>☕ Pesanan Baru Masuk</h2>

    <p><strong>Nama:</strong> {{ $order->name }}</p>
    <p><strong>No HP:</strong> {{ $order->phone }}</p>
    <p><strong>Alamat:</strong> {{ $order->address }}</p>

    <hr>

    <p><strong>Total Item:</strong> {{ $order->items->count() }}</p>

    <p>Status: <strong>Menunggu Pembayaran</strong></p>

</body>
</html>
