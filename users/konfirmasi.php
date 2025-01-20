<?php

include('koneksi.php');

// Pastikan sesi untuk ID pesanan ada
if (!isset($_SESSION['id_pesanan'])) {
    echo "ID Pesanan tidak ditemukan. Silakan lakukan checkout terlebih dahulu.";
    exit();
}

$order_id = $_SESSION['id_pesanan'];

// Ambil data pesanan
$stmt = $conn->prepare("SELECT * FROM orders WHERE id_pesanan = ?");
if (!$stmt) {
    die("Query gagal: " . $conn->error);
}
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Pastikan pesanan ditemukan
if ($result->num_rows === 0) {
    echo "Pesanan dengan ID tersebut tidak ditemukan.";
    exit();
}
$order = $result->fetch_assoc();

// Ambil data item pesanan
$stmt = $conn->prepare("SELECT * FROM order_items WHERE id_pesanan = ?");
if (!$stmt) {
    die("Query gagal: " . $conn->error);
}
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center">Konfirmasi Pesanan</h2>
        
        <!-- Ringkasan Pesanan -->
        <div class="order-summary">
            <h4>Detail Pesanan</h4>
            <p><strong>ID Pesanan:</strong> <?= htmlspecialchars($order['id_pesanan']) ?></p>
            <p><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($order['nama_pelanggan']) ?></p>
            <p><strong>Tanggal Pesanan:</strong> <?= htmlspecialchars($order['tanggal_pesanan']) ?></p>
            <p><strong>Alamat Pengiriman:</strong> <?= htmlspecialchars($order['alamat_pengiriman']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
            <p><strong>Total Harga:</strong> Rp<?= number_format($order['total'], 2) ?></p>
        </div>

        <!-- Tabel Item Pesanan -->
        <h4>Item Pesanan</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $order_items->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nama']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Rp<?= number_format($item['price'], 2) ?></td>
                        <td>Rp<?= number_format($item['total'], 2) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Tombol Kembali -->
        <div class="text-center mt-4">
            <a href="utama.php" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
