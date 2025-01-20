<?php
include 'koneksi.php'; // Pastikan koneksi database

// Ambil ID penjual dari URL
if (isset($_GET['id'])) {
    $id_penjual = $_GET['id'];

    // Query untuk mengambil data penjual berdasarkan ID
    $query_seller = "SELECT * FROM seller WHERE id_penjual = '$id_penjual'";
    $result_seller = mysqli_query($koneksi, $query_seller);
    $seller = mysqli_fetch_assoc($result_seller);

    if (!$seller) {
        echo "<script>alert('Seller not found!'); window.location='utama.php?page=seller';</script>";
        exit;
    }

    // Query untuk mengambil produk yang terkait dengan penjual
    $query_produk = "SELECT id_produk, nama_produk, deskripsi, harga, ketersediaan_stok, gambar 
                     FROM produk 
                     WHERE id_penjual = '$id_penjual'";
    $result_produk = mysqli_query($koneksi, $query_produk);
} else {
    echo "<script>alert('ID Penjual gagal diproses!'); window.location='utama.php?page=seller';</script>";
    exit;
}
?>

<section class="content-main">
    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h2 class="content-title">Produk dari <?php echo htmlspecialchars($seller['toko']); ?></h2>
                <a href="utama.php?page=seller" class="btn btn-primary">Kembali ke daftar penjual</a>
            </div>
        </div>

        <!-- Detail Penjual -->
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Detail Penjual</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td><?php echo htmlspecialchars($seller['id_penjual']); ?></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td><?php echo htmlspecialchars($seller['username']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($seller['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Nama Toko</th>
                            <td><?php echo htmlspecialchars($seller['toko']); ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?php echo htmlspecialchars($seller['status']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Produk Penjual -->
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Daftar Produk</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Foto Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (mysqli_num_rows($result_produk) > 0): ?>
                                <?php while ($produk = mysqli_fetch_assoc($result_produk)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($produk['id_produk']); ?></td>
                                        <td>
                                            <?php if (!empty($produk['gambar']) && file_exists("../upload/" . $produk['gambar'])): ?>
                                                <img src="../upload/<?php echo htmlspecialchars($produk['gambar']); ?>" alt="<?php echo htmlspecialchars($produk['nama_produk']); ?>" style="max-width: 100px;">
                                            <?php else: ?>
                                                <img src="../assets/images/no-image.png" alt="No image available" style="max-width: 100px;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($produk['nama_produk']); ?></td>
                                        <td><?php echo htmlspecialchars($produk['deskripsi']); ?></td>
                                        <td>Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($produk['ketersediaan_stok']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada produk untuk penjual ini.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="../assets/js/vendors/jquery-3.6.0.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/select2.min.js"></script>
<script src="../assets/js/vendors/perfect-scrollbar.js"></script>
<script src="../assets/js/vendors/jquery.fullscreen.min.js"></script>
<script src="../assets/js/main.js"></script>
