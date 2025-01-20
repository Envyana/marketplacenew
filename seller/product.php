<?php
include 'koneksi.php';

// Periksa apakah sesi penjual sudah aktif
if (!isset($_SESSION['id_penjual'])) {
    die('<div style="color:red">Error: Anda belum login sebagai penjual. Harap login terlebih dahulu.</div>');
}

$id_penjual = $_SESSION['id_penjual']; // Ambil ID penjual dari sesi

// Query untuk mengambil data produk milik penjual yang sedang login
$query = "SELECT id_produk, id_kategori, nama_produk, deskripsi, harga, ketersediaan_stok, warna, ukuran, gambar, berat 
          FROM produk 
          WHERE id_penjual = '$id_penjual'";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi)); // Menampilkan error jika query gagal
}
?>
<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Daftar Produk</h2>
        </div>
        <div>
            <!-- Tombol untuk menambahkan produk baru -->
            <a href="utamapenjual.php?page=addproduct" class="btn btn-primary btn-sm rounded"><i class="material-icons md-plus"></i> Tambah Produk Baru</a>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <!-- Header Tabel -->
                <div class="table-header mb-3">
                    <div class="row align-items-center">
                        <div class="col-lg-1 col-sm-1 col-2"><strong>No</strong></div>
                        <div class="col-lg-3 col-sm-3 col-6"><strong>Gambar</strong></div>
                        <div class="col-lg-3 col-sm-3 col-6"><strong>Nama Produk & Deskripsi</strong></div>
                        <div class="col-lg-2 col-sm-2 col-4"><strong>Harga</strong></div>
                        <div class="col-lg-1 col-sm-1 col-2"><strong>Stok</strong></div>
                        <div class="col-lg-1 col-sm-1 col-2"><strong>Warna</strong></div>
                        <div class="col-lg-1 col-sm-1 col-2"><strong>Ukuran</strong></div>
                        <div class="col-lg-2 col-sm-2 col-4"><strong>Kategori</strong></div>
                        <div class="col-lg-1 col-sm-1 col-2"><strong>Berat</strong></div>
                    </div>
                </div>
                <!-- List Produk -->
                <?php
                $nomor = 1; // Inisialisasi nomor urut
                while ($row = mysqli_fetch_assoc($result)):
                ?>
                    <article class="itemlist mb-3">
                        <div class="row align-items-center">
                            <!-- Nomor -->
                            <div class="col-lg-1 col-sm-1 col-2">
                                <h6 class="mb-0"><?php echo $nomor++; ?></h6>
                            </div>
                            <!-- Gambar Produk -->
                            <div class="col-lg-3 col-sm-3 col-6">
                                <?php if (!empty($row['gambar']) && file_exists("../upload/" . $row['gambar'])): ?>
                                    <img src="../upload/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>" class="img-fluid" style="max-width: 100px; height: auto;">
                                <?php else: ?>
                                    <img src="../assets/images/no-image.png" alt="No image available" class="img-fluid" style="max-width: 100px; height: auto;">
                                <?php endif; ?>
                            </div>
                            <!-- Nama Produk & Deskripsi -->
                            <div class="col-lg-3 col-sm-3 col-6">
                                <h6 class="mb-0"><?php echo htmlspecialchars($row['nama_produk']); ?></h6>
                                <p class="text-muted"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                            </div>
                            <!-- Harga -->
                            <div class="col-lg-2 col-sm-2 col-4">
                                <span>Rp <?php echo number_format((double)$row['harga'], 0, ',', '.'); ?></span>
                            </div>
                            <!-- Stok -->
                            <div class="col-lg-1 col-sm-2 col-4">
                                <span>Stock: <?php echo $row['ketersediaan_stok']; ?></span>
                            </div>
                            <div class="col-lg-1 col-sm-2 col-4">
                                <span>warna: <?php echo $row['warna']; ?></span>
                            </div>
                            <div class="col-lg-1 col-sm-2 col-4">
                                <span>ukuran: <?php echo $row['ukuran']; ?></span>
                            </div>
                            <!-- Kategori -->
                            <div class="col-lg-2 col-sm-1 col-2">
                                <?php
                                $kategori_query = "SELECT nama_kategori FROM kategori WHERE id_kategori = '" . $row['id_kategori'] . "'";
                                $kategori_result = mysqli_query($koneksi, $kategori_query);

                                if ($kategori_result && mysqli_num_rows($kategori_result) > 0) {
                                    $kategori_row = mysqli_fetch_assoc($kategori_result);
                                    echo htmlspecialchars($kategori_row['nama_kategori']);
                                } else {
                                    echo "No category";
                                }
                                ?>
                            </div>
                            <!-- Berat -->
                            <div class="col-lg-1 col-sm-1 col-2">
                                <span>Berat: <?php echo $row['berat']; ?> gram</span>
                            </div>
                        </div>
                        <!-- Aksi -->
                        <div class="row mt-2">
                            <div class="col-12 text-end">
                                <a href="utamapenjual.php?page=editproduct&id_produk=<?php echo $row['id_produk']; ?>" class="btn btn-sm btn-brand">
                                    <i class="material-icons md-edit"></i> Edit
                                </a>
                                <a href="deleteproduct.php?id_produk=<?php echo $row['id_produk']; ?>" class="btn btn-sm btn-light" onclick="return confirm('Anda yakin ingin menghapus produk ini?');">
                                    <i class="material-icons md-delete_forever"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Pesan jika data produk tidak ditemukan -->
                <p class="text-center">Belum ada data produk. Klik "Tambah Produk Baru" untuk membuat produk baru.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<script src="../assets/js/vendors/jquery-3.6.0.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/select2.min.js"></script>
<script src="../assets/js/vendors/perfect-scrollbar.js"></script>
<script src="../assets/js/vendors/jquery.fullscreen.min.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>
