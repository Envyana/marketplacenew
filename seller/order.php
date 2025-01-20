<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php'; // Koneksi database

// Cek apakah user sudah login
if (!isset($_SESSION['id_penjual'])) {
    die("<div class='alert alert-danger'>Anda harus login untuk melihat halaman ini.</div>");
}

// Ambil id_penjual dari session
$id_penjual = $_SESSION['id_penjual'];

// Query hanya untuk pesanan yang terkait dengan id_penjual yang login
$query_orders = "SELECT id_pesanan, id_penjual, user_id, nama_pelanggan, tanggal_pesanan, status, total, alamat_pengiriman 
                 FROM orders 
                 WHERE id_penjual = ?";
$stmt = mysqli_prepare($koneksi, $query_orders);
mysqli_stmt_bind_param($stmt, 'i', $id_penjual);
mysqli_stmt_execute($stmt);
$result_order = mysqli_stmt_get_result($stmt);

if (!$result_order) {
    die("Query error: " . mysqli_error($koneksi));
}

// Cek apakah ada data pesanan
if (mysqli_num_rows($result_order) > 0) {
    ?>
    <form action="utamapenjual.php?page=order" method="get">
        <section class="content-main">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Daftar Pesanan</h2>
                    <p>Daftar pesanan pelanggan.</p>
                </div>
                <div>
                    <input type="text" placeholder="Search order ID" class="form-control bg-white" />
                </div>
            </div>
            <div class="card mb-4">
                <header class="card-header">
                    <div class="row gx-3">
                        <div class="col-lg-4 col-md-6 me-auto">
                            <input type="text" placeholder="Search..." class="form-control" />
                        </div>
                        <div class="col-lg-2 col-6 col-md-3">
                            <select class="form-select">
                                <option>Status</option>
                                <option>Menunggu Konfirmasi</option>
                                <option>Dalam Proses</option>
                                <option>Dikirim</option>
                                <option>Selesai</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-6 col-md-3">
                            <select class="form-select">
                                <option>Show 20</option>
                                <option>Show 30</option>
                                <option>Show 40</option>
                            </select>
                        </div>
                    </div>
                </header>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_order)) { 
                                    $total_harga = $row['total'] + 10000; // Contoh tambahan biaya
                                ?>
                                <tr>
                                    <td><?php echo $row['id_pesanan']; ?></td>
                                    <td><b><?php echo $row['nama_pelanggan']; ?></b></td>
                                    <td>Rp.<?php echo number_format($total_harga, 0); ?></td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 'Menunggu Konfirmasi') { ?>
                                            <span class="badge rounded-pill alert-warning">Menunggu Konfirmasi</span>
                                        <?php } elseif ($row['status'] == 'Dalam Proses') { ?>
                                            <span class="badge rounded-pill alert-primary">Dalam Proses</span>
                                        <?php } elseif ($row['status'] == 'Dikirim') { ?>
                                            <span class="badge rounded-pill alert-info">Dikirim</span>
                                        <?php } elseif ($row['status'] == 'Selesai') { ?>
                                            <span class="badge rounded-pill alert-success">Selesai</span>
                                        <?php } else { ?>
                                            <span class="badge rounded-pill alert-secondary">Unknown</span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo date('d-m-Y', strtotime($row['tanggal_pesanan'])); ?></td>
                                    <td class="text-end">
                                        <a href="utamapenjual.php?page=detailorder&id_pesanan=<?php echo $row['id_pesanan']; ?>" class="btn btn-md rounded font-sm">Detail</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pagination-area mt-15 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        <li class="page-item active"><a class="page-link" href="#">01</a></li>
                        <li class="page-item"><a class="page-link" href="#">02</a></li>
                        <li class="page-item"><a class="page-link" href="#">03</a></li>
                        <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">16</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="material-icons md-chevron_right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
    </form>
    <?php
} else {
    echo "<div class='alert alert-warning'>Tidak ada pesanan untuk toko Anda.</div>";
}
?>
