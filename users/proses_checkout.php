<?php
require_once '../vendor/autoload.php'; // Pastikan Composer sudah terpasang dengan benar

// Konfigurasi Midtrans
\Midtrans\Config::$serverKey = 'SB-Mid-server-7QQYULsxoFTmtxipc-vp6CNK'; // Ganti dengan server key Midtrans Anda
\Midtrans\Config::$isProduction = false; // Ubah ke true jika menggunakan mode production
\Midtrans\Config::$isSanitized = true; // Untuk mengamankan data
\Midtrans\Config::$is3ds = true; // Aktifkan 3D Secure jika diperlukan

// Ambil data dari form
$total_price = isset($_POST['total_price']) ? round($_POST['total_price']) : 0;
$customer_name = isset($_POST['customer_name']) ? htmlspecialchars($_POST['customer_name']) : '';
$customer_phone = isset($_POST['customer_phone']) ? htmlspecialchars($_POST['customer_phone']) : '';
$customer_address = isset($_POST['customer_address']) ? htmlspecialchars($_POST['customer_address']) : '';

// Validasi data
if ($total_price <= 0) {
    echo "Error: Total harga tidak valid.";
    exit();
}

if (empty($customer_name) || empty($customer_phone) || empty($customer_address)) {
    echo "Error: Data pelanggan tidak lengkap.";
    exit();
}

// Buat parameter transaksi
$order_id = uniqid("ORDER-"); // ID unik untuk setiap transaksi
$params = [
    'transaction_details' => [
        'order_id' => $order_id,
        'gross_amount' => $total_price,
    ],
    'customer_details' => [
        'first_name' => $customer_name,
        'phone' => $customer_phone,
        'address' => $customer_address,
    ],
];

// Generate Snap Token
try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pembayaran</title>
    <link rel="stylesheet" href="styles.css"> <!-- Tetap gunakan CSS yang ada -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-hBtikd0X9fOilxDG"></script>
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Proses Pembayaran</h2>

        <!-- Detail Pesanan -->
        <div class="order-details">
            <h3>Detail Pesanan</h3>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Order ID</th>
                        <td><?= htmlspecialchars($order_id) ?></td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td>Rp<?= number_format($total_price, 2, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Data Pelanggan -->
        <div class="customer-details mt-4">
            <h3>Data Pelanggan</h3>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td><?= htmlspecialchars($customer_name) ?></td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon</th>
                        <td><?= htmlspecialchars($customer_phone) ?></td>
                    </tr>
                    <tr>
                        <th>Alamat Pengiriman</th>
                        <td><?= nl2br(htmlspecialchars($customer_address)) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tombol Pembayaran -->
        <div class="payment-section mt-5 text-center">
            <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
        </div>
    </div>

    <script>
        // Konfigurasi tombol pembayaran Midtrans
        document.getElementById('pay-button').addEventListener('click', function () {
            snap.pay('<?= $snapToken ?>', {
                onSuccess: function (result) {
                    console.log("Transaksi Berhasil:", result);
                    window.location.href = "sukses.php?order_id=<?= $order_id ?>";
                },
                onPending: function (result) {
                    console.log("Transaksi Tertunda:", result);
                    alert("Pembayaran tertunda. Mohon tunggu konfirmasi.");
                },
                onError: function (result) {
                    console.log("Terjadi Kesalahan:", result);
                    alert("Pembayaran gagal. Silakan coba lagi.");
                },
                onClose: function () {
                    alert("Anda telah menutup jendela pembayaran.");
                }
            });
        });
    </script>
</body>
</html>

