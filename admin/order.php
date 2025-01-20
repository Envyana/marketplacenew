<?php
include 'koneksi.php'; // Koneksi database

// Query untuk mengambil data pesanan
$query_orders = "SELECT id_pesanan, user_id, nama_pelanggan, tanggal_pesanan, status, total, alamat_pengiriman FROM orders";
$result_order = mysqli_query($koneksi, $query_orders);

// Cek apakah query berhasil
if (!$result_order) {
    die("Query error: " . mysqli_error($koneksi));
}

// Jika data pesanan ditemukan
if (mysqli_num_rows($result_order) > 0) { 
    $nomor = 1; // Inisialisasi nomor urut
?>
    <form action="utama.php?page=order" method="get">
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
                <!-- card-header end// -->
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
                                    $total_harga = $row['total'] + 10000; // Tambahkan biaya tambahan jika ada
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id_pesanan']); ?></td>
                                    <td><b><?php echo htmlspecialchars($row['nama_pelanggan']); ?></b></td>
                                    <td>Rp.<?php echo number_format($total_harga, 0, ',', '.'); ?></td>
                                    <td>
                                        <?php
                                        // Tampilkan status dalam bentuk badge
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
                                        <a href="utama.php?page=detailorder&id_pesanan=<?php echo htmlspecialchars($row['id_pesanan']); ?>" class="btn btn-md rounded font-sm">Detail</a>
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
    echo "<div class='alert alert-warning'>Data tidak ditemukan.</div>";
}
?>
<script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
<script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="assets/js/vendors/select2.min.js"></script>
<script src="assets/js/vendors/perfect-scrollbar.js"></script>
<script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
<!-- Main Script -->
<script src="assets/js/main.js?v=1.1" type="text/javascript"></script>