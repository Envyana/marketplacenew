<?php
include 'koneksi.php'; // Koneksi database

$query_orders = "
SELECT 
    pembayaran.id_pembayaran,
    pembayaran.id_pesanan, 
    orders.user_id, 
    users.username AS nama_pelanggan, 
    pembayaran.metode_pembayaran,
    pembayaran.status, 
    pembayaran.tanggal, 
    pembayaran.jumlah,
    orders.total, 
    orders.alamat_pengiriman
FROM pembayaran
JOIN orders ON pembayaran.id_pesanan = orders.id_pesanan
JOIN users ON orders.user_id = users.user_id
";

$result_order = mysqli_query($koneksi, $query_orders);

if (!$result_order) {
    die("Query error: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($result_order) > 0) { 
    $nomor = 1; 
    ?>
    <form action="utama.php?page=order" method="get">
    <section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Transaksi</h2>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th scope="col">Nama Pelanggan</th>
                    <th scope="col">Total Bayar</th>
                    <th scope="col">Metode</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 1; 
                while ($row = mysqli_fetch_assoc($result_order)) {
                ?>
                <tr>
                    <td><b><?php echo $nomor++; ?></b></td>
                    <td><?php echo $row['nama_pelanggan']; ?></td>
                    <td><?php echo "Rp " . number_format($row['total'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['metode_pembayaran']; ?></td>
                    <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                    <td class="text-end">
                        <a href="utama.php?page=transaksidetail&id_pembayaran=<?php echo $row['id_pembayaran']; ?>" class="btn btn-md rounded font-sm">Detail</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>
</form>
    <?php
} else {
    echo "<div class='alert alert-warning'>Data tidak ditemukan.</div>";
}
?>