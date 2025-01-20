<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php'; // Koneksi database

// Cek apakah user sudah login
if (!isset($_SESSION['id_penjual'])) {
    die("<div class='alert alert-danger'>Anda harus login untuk melihat halaman ini.</div>");
}

// Ambil user_id dari session
$id_penjual = $_SESSION['id_penjual'];

// Ambil id_pesanan dari parameter GET
if (isset($_GET['id_pesanan'])) {
    $id_pesanan = $_GET['id_pesanan'];

    // Query untuk mendapatkan detail pesanan berdasarkan id_pesanan
    $query_order = "
        SELECT id_pesanan, user_id, nama_pelanggan, tanggal_pesanan, alamat_pengiriman, status, total
        FROM orders
        WHERE id_pesanan = '$id_pesanan'
    ";
    $result_order = mysqli_query($koneksi, $query_order);

    if (!$result_order) {
        die("Query error: " . mysqli_error($koneksi));
    }

    // Periksa apakah data ditemukan
    if (mysqli_num_rows($result_order) > 0) {
        $order = mysqli_fetch_assoc($result_order);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Order Detail</title>
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        </head>
        <body>
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Order detail</h2>
                    <p>Details for Order ID: <?php echo $order['id_pesanan']; ?></p>
                </div>
            </div>
            <div class="card">
                <header class="card-header">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 mb-lg-0 mb-15">
                            <span><i class="material-icons md-calendar_today"></i>
                                <b><?php echo date('D, M d, Y, h:i A', strtotime($order['tanggal_pesanan'])); ?></b>
                            </span><br>
                            <small class="text-muted">Order ID: <?php echo $order['id_pesanan']; ?></small>
                        </div>
                        <div class="col-lg-6 col-md-6 ms-auto text-md-end">
                            <select class="form-select d-inline-block mb-lg-0 mr-5 mw-200">
                                <option <?php echo $order['status'] == 'Menunggu Konfirmasi' ? 'selected' : ''; ?>>Menunggu Konfirmasi</option>
                                <option <?php echo $order['status'] == 'Dalam Proses' ? 'selected' : ''; ?>>Dalam Proses</option>
                                <option <?php echo $order['status'] == 'Dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                                <option <?php echo $order['status'] == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                            </select>
                            <a class="btn btn-primary" href="#">Save</a>
                            <a class="btn btn-secondary print ms-2" href="#"><i class="icon material-icons md-print"></i></a>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <div class="row mb-50 mt-20 order-info-wrap">
                        <div class="col-md-4">
                            <article class="icontext align-items-start">
                                <span class="icon icon-sm rounded-circle bg-primary-light">
                                    <i class="text-primary material-icons md-person"></i>
                                </span>
                                <div class="text">
                                    <h6 class="mb-1">Customer</h6>
                                    <p class="mb-1">
                                        <?php echo $order['nama_pelanggan']; ?><br>
                                    </p>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article class="icontext align-items-start">
                                <span class="icon icon-sm rounded-circle bg-primary-light">
                                    <i class="text-primary material-icons md-local_shipping"></i>
                                </span>
                                <div class="text">
                                    <h6 class="mb-1">Order info</h6>
                                    <p class="mb-1">
                                        Status: <?php echo $order['status']; ?><br>
                                    </p>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article class="icontext align-items-start">
                                <span class="icon icon-sm rounded-circle bg-primary-light">
                                    <i class="text-primary material-icons md-place"></i>
                                </span>
                                <div class="text">
                                    <h6 class="mb-1">Deliver to</h6>
                                    <p class="mb-1">
                                        <?php echo $order['alamat_pengiriman']; ?>
                                    </p>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="box shadow-sm bg-light">
                                <p>Total Order: <strong>Rp<?php echo number_format($order['total'], 0); ?></strong></p>
                                <p>Shipping Cost: <strong>Rp10,000</strong></p>
                                <h5>Total Payment: <strong>Rp<?php echo number_format($order['total'] + 10000, 0); ?></strong></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </body>
        </html>
        <?php
    } else {
        echo "<div class='alert alert-warning'>Pesanan tidak ditemukan.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID Pesanan tidak valid.</div>";
}
?>
