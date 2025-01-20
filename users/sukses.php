<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
} else {
    $order_id = "Tidak ada Order ID";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 20px 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .content p {
            margin: 10px 0;
            font-size: 16px;
            color: #333333;
        }
        .content strong {
            color: #4CAF50;
        }
        .footer {
            background-color: #f9f9f9;
            text-align: center;
            padding: 15px 0;
            font-size: 14px;
            color: #666666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pembayaran Berhasil!</h1>
        </div>
        <div class="content">
            <p>Terima kasih telah berbelanja di toko kami.</p>
            <p>ID Pesanan Anda: <strong><?= htmlspecialchars($order_id) ?></strong></p>
            <p>Pesanan Anda sedang kami proses. Harap tunggu konfirmasi lebih lanjut melalui email atau telepon Anda.</p>
            <a href="index_user.php" class="btn">Kembali ke Halaman Utama</a>
        </div>
        <div class="footer">
            &copy; <?= date('Y') ?> Toko Kami. Semua Hak Dilindungi.
        </div>
    </div>
</body>
</html>
