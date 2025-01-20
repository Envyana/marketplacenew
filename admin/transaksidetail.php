<?php
include 'koneksi.php'; // Koneksi database

// Ambil id_pembayaran dari parameter GET
if (isset($_GET['id_pembayaran'])) {
    $id_pembayaran = $_GET['id_pembayaran'];

    // Query untuk mendapatkan detail orders dan pembayaran berdasarkan id_pembayaran
    $query_payment = "
        SELECT 
            orders.id_pesanan, 
            orders.user_id, 
            orders.total, 
            orders.tanggal_pesanan AS tanggal_orders, 
            orders.status AS status_orders, 
            orders.alamat_pengiriman, 
            users.email, 
            pembayaran.metode_pembayaran, 
            pembayaran.tanggal AS tanggal_pembayaran,
            pembayaran.status AS status_pembayaran
        FROM orders
        JOIN users ON orders.user_id = users.user_id
        JOIN pembayaran ON orders.id_pesanan = pembayaran.id_pesanan
        WHERE pembayaran.id_pembayaran = '$id_pembayaran'
    ";

    // Eksekusi query
    $result_payment = mysqli_query($koneksi, $query_payment);

    if (!$result_payment) {
        die("Query error: " . mysqli_error($koneksi));
    }

    // Periksa apakah data ditemukan
    if (mysqli_num_rows($result_payment) > 0) {
        $payment = mysqli_fetch_assoc($result_payment);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Detail Transaksi</title>
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        </head>
        <body>
        <section class="content-main">
            <div class="content-header">
                <h2 class="content-title">Detail Transaksi</h2>
            </div>

            <div class="box bg-light" style="min-height: 80%">
                <h6 class="mb-0">Tanggal Pembelian:</h6>
                <p><?php echo date('F d, Y', strtotime($payment['tanggal_pembayaran'])); ?></p>
                <br />
                <h6 class="mb-0">Alamat Pengiriman:</h6>
                <p><?php echo $payment['alamat_pengiriman']; ?></p>
                <br />
                <h6 class="mb-0">Email Pembeli:</h6>
                <p><?php echo $payment['email']; ?></p>
                <br />
                <h6 class="mb-0">Metode Pembayaran:</h6>
                <p><?php echo $payment['metode_pembayaran']; ?></p>
                <br />
                <h6 class="mb-0">Status Pembayaran:</h6>
                <p><?php echo $payment['status_pembayaran']; ?></p>
                <br />
                <p class="h4">Total Pembayaran: Rp<?php echo number_format($payment['total'], 0, ',', '.'); ?></p>
                <hr />
                <a class="btn btn-light" href="#">Download Resi</a>
            </div>
        </section>
        </body>
        </html>
        <?php
    } else {
        echo "<div class='alert alert-warning'>Pembayaran tidak ditemukan.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID Pembayaran tidak valid.</div>";
}
?>