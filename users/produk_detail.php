<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'marketplace'); // Ganti 'ecommerce' sesuai database Anda

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Ambil ID produk dari URL
$id_produk = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_produk <= 0) {
    die("ID produk tidak valid.");
}

// Query untuk mengambil data produk berdasarkan ID
$sql = "SELECT * FROM produk WHERE id_produk = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Query gagal: " . $conn->error);
}

$stmt->bind_param("i", $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $produk = $result->fetch_assoc();
} else {
    die("Produk tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - <?php echo htmlspecialchars($produk['nama_produk']); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="colorlib-product">
        <div class="container">
            <div class="row row-pb-lg product-detail-wrap">
                <!-- Bagian untuk Carousel Gambar -->
                <div class="col-sm-8">
    <div class="container">
        <?php
        // Mendapatkan nama gambar dari database
        $produk_image = isset($produk['gambar']) ? $produk['gambar'] : null; // Kolom 'gambar' dari database
        $upload_dir = '../upload/'; // Direktori tempat gambar disimpan
        $gambar_placeholder = $upload_dir . 'placeholder.jpg'; // Placeholder jika gambar tidak ditemukan

        // Path lengkap ke gambar produk
        $gambar_path = $upload_dir . $produk_image;

        // Mengecek apakah file gambar ada dan valid
        if (!empty($produk_image) && file_exists($gambar_path)) {
            $gambar_url = $gambar_path; // Gunakan gambar dari database
        } else {
            $gambar_url = $gambar_placeholder; // Gunakan placeholder jika gambar tidak ditemukan
        }

        // Menampilkan gambar dalam carousel
        ?>
        <div class="item">
            <div class="product-entry border">
                <a href="<?= htmlspecialchars($gambar_url) ?>" class="prod-img">
                    <div class="product-img" style="background-image: url('<?= htmlspecialchars($gambar_url) ?>');">
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>


                <!-- Bagian Deskripsi Produk -->
                <div class="col-sm-4">
                    <div class="product-desc">
                        <h3><?php echo htmlspecialchars($produk['nama_produk']); ?></h3>
                        <p class="price">
                            <span>Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></span>
                            <span class="rate">
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-full"></i>
                                <i class="icon-star-half"></i>
                                (74 Ratings) <!-- Ubah nilai rating sesuai kebutuhan -->
                            </span>
                        </p>
                        <p><?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?></p>
                        <div class="size-wrap">
                            <div class="block-26 mb-2">
                                <h4>Ukuran</h4>
                                <ul>
                                    <?php
                                    // Menampilkan ukuran dari database (asumsikan format ukuran dipisah dengan koma)
                                    $sizes = explode(',', $produk['ukuran']);
                                    foreach ($sizes as $size) {
                                        echo '<li><a href="#">' . htmlspecialchars(trim($size)) . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="block-26 mb-4">
                                <h4>Warna</h4>
                                <ul>
                                    <li><a href="#"><?php echo htmlspecialchars($produk['warna']); ?></a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Formulir untuk Quantity -->
                        <form action="tambah_keranjang.php" method="POST">
                            <div class="input-group mb-4">
                                <span class="input-group-btn">     
                                </span>
                                <input type="number" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
                                <span class="input-group-btn ml-1">
                                </span>
                            </div>

                            <!-- Kirimkan ID produk dan quantity -->
                            <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <p class="addtocart">
                                        <button type="submit" class="btn btn-primary btn-addtocart d-flex align-items-center justify-content-center">
                                           <i class="icon-shopping-cart mr-2"></i> Tambahkan Keranjang
                                        </button>
                                    </p>
                                    <a href="utama.php?page=produk" class="btn btn-secondary">Kembali ke Daftar Produk</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Bagian Deskripsi dan Ulasan -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-12 pills">
                            <div class="bd-example bd-example-tabs">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab" aria-controls="pills-description" aria-expanded="true">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review" role="tab" aria-controls="pills-review" aria-expanded="true">Review</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane border fade show active" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
                                        <p><?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?></p>
                                    </div>
                                    <div class="tab-pane border fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                                        <h3 class="head">Belum ada ulasan</h3> <!-- Tambahkan fitur ulasan jika tersedia -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
