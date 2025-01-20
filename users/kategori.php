<?php
// Koneksi ke database
include('koneksi.php');

// Ambil id_kategori dari parameter URL
$id_kategori = isset($_GET['id_kategori']) ? intval($_GET['id_kategori']) : 0;

// Query untuk mengambil data produk berdasarkan id_kategori
$sql = "SELECT * FROM produk WHERE id_kategori = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_kategori);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="breadcrumbs-two">
    <div class="container">
        <br></br>
    </div>
</div>

<!-- Featured Section -->
<div class="colorlib-featured">
    <div class="container">
        <div class="row">
            <?php
            // Periksa jika data produk ada
            if ($result->num_rows > 0) {
                // Loop untuk menampilkan produk dalam format kolom
                while ($row = $result->fetch_assoc()) {
                    $file_path = '../upload/' . $row['gambar']; // Path relatif
                    $gambar = file_exists($file_path) ? $file_path : 'upload/placeholder.jpg'; // Placeholder jika tidak ditemukan
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="featured border rounded shadow-sm d-flex flex-column h-100">
                            <!-- Bagian Gambar -->
                            <div class="featured-img" 
                                 style="background-image: url('<?php echo htmlspecialchars($gambar); ?>'); 
                                        background-size: cover; 
                                        background-position: center; 
                                        height: 250px; 
                                        border-radius: 8px 8px 0 0;">
                            </div>
                            <!-- Bagian Informasi Produk -->
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <!-- Nama dan Harga -->
                                <div class="mb-3">
                                    <h5 class="text-dark font-weight-bold mb-1"><?php echo htmlspecialchars($row['nama_produk']); ?></h5>
                                    <p class="text-primary font-weight-bold mb-0">
                                        Rp<?php echo number_format($row['harga'], 0, ',', '.'); ?>
                                    </p>
                                </div>
                                <!-- Warna dan Ukuran -->
                                <div class="mb-3">
                                    <p class="mb-1"><strong>Ukuran:</strong> <?php echo htmlspecialchars($row['ukuran']); ?></p>
                                    <p class="mb-0"><strong>Warna:</strong> <?php echo htmlspecialchars($row['warna']); ?></p>
                                </div>
                                <!-- Tombol -->
                                <a href="utama.php?page=produk_detail&id=<?php echo $row['id_produk']; ?>" 
                                   class="btn btn-primary mt-auto btn-block text-white">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-center'>No products available for this category.</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- Product Pagination -->
<div class="row">
    <div class="col-md-12 text-center">
        <div class="block-27">
            <!-- Pagination logic can be added here -->
        </div>
    </div>
</div>
