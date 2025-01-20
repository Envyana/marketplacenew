<?php
include 'koneksi.php'; // Menghubungkan ke database

// Periksa apakah parameter `id_produk` tersedia di URL dan tidak kosong
if (isset($_GET['id_produk']) && !empty($_GET['id_produk'])) {
    // Ambil ID produk dari parameter URL
    $id_produk = $_GET['id_produk'];

    // Query untuk mengambil data produk berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk = '$id_produk'");
    $gambar = mysqli_fetch_assoc($query);

    // Periksa apakah produk ditemukan
    if (!$gambar) {
        echo "Produk tidak ditemukan!";
        exit;
    }
} else {
    echo "ID produk tidak ditemukan.";
    exit;
}

// Periksa apakah form telah disubmit untuk menyimpan perubahan
if (isset($_POST["submit"])) {
    // Ambil data dari form
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $ketersediaan_stok = $_POST['ketersediaan_stok'];
    $id_kategori = $_POST['id_kategori'];

    // Proses unggah file foto baru jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $asal = $_FILES['gambar']['tmp_name'];
        $nama_file = $_FILES['gambar']['name'];
        $tempat_simpan_foto = "upload/$nama_file";

        // Hapus foto lama jika ada
        if (!empty($gambar['gambar']) && file_exists("upload/" . $gambar['gambar'])) {
            unlink("upload/" . $gambar['gambar']);
        }

        // Pindahkan foto baru ke folder uploads
        if (move_uploaded_file($asal, $tempat_simpan_foto)) {
            $updateQuery = "UPDATE produk SET 
                                nama_produk = '$nama_produk',
                                deskripsi = '$deskripsi', 
                                harga = '$harga', 
                                ketersediaan_stok = '$ketersediaan_stok',
                                id_kategori = '$id_kategori',
                                gambar = '$nama_file'
                            WHERE id_produk = '$id_produk'";
        } else {
            echo "Gagal mengunggah foto produk.";
            exit;
        }
    } else {
        // Jika tidak ada foto baru, hanya update data lainnya
        $updateQuery = "UPDATE produk SET 
                            nama_produk = '$nama_produk',
                            deskripsi = '$deskripsi', 
                            harga = '$harga',
                            id_kategori = '$id_kategori', 
                            ketersediaan_stok = '$ketersediaan_stok'
                        WHERE id_produk = '$id_produk'";
    }

    $updateResult = mysqli_query($koneksi, $updateQuery);

    // Periksa apakah update berhasil
    if ($updateResult) {
        echo '<script>alert("Produk berhasil diupdate!"); window.location.href="utamapenjual.php?page=product";</script>';
    } else {
        echo "Gagal mengupdate produk: " . mysqli_error($koneksi);
    }
}
?>

<!-- HTML Form untuk edit produk -->
<form action="editproduct.php?id_produk=<?php echo $id_produk; ?>" method="post" enctype="multipart/form-data">
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Edit Product</h2>
            </div>
            <div>
                <a href="utamapenjual.php?page=product " class="btn btn-secondary btn-sm rounded">Back to Product List</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" placeholder="Type here" name="nama_produk" 
                           value="<?php echo htmlspecialchars($gambar['nama_produk'] ?? '', ENT_QUOTES); ?>" 
                           class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea placeholder="Type here" name="deskripsi" class="form-control"><?php echo htmlspecialchars($gambar['deskripsi'] ?? '', ENT_QUOTES); ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga</label>
                    <input type="number" placeholder="Masukkan harga produk" name="harga" 
                           value="<?php echo htmlspecialchars($gambar['harga'] ?? '', ENT_QUOTES); ?>" 
                           class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Stok</label>
                    <input type="number" placeholder="Type here" name="stok" 
                           value="<?php echo htmlspecialchars($ketersediaan_stok['ketersediaan_stok'] ?? '', ENT_QUOTES); ?>" 
                           class="form-control">
                </div>
                <div class="form-group">
                    <label for="id_kategori">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-control" required>
                        <!-- Daftar kategori dari database -->
                        <?php
                        $kategori_query = "SELECT * FROM kategori";
                        $kategori_result = mysqli_query($koneksi, $kategori_query);

                        if ($kategori_result && mysqli_num_rows($kategori_result) > 0) {
                            while ($kategori = mysqli_fetch_assoc($kategori_result)) {
                                // Periksa apakah kategori ini adalah kategori produk yang sedang diedit
                                $selected = ($kategori['id_kategori'] == $gambar['id_kategori']) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($kategori['id_kategori'], ENT_QUOTES) . "' $selected>" . 
                                    htmlspecialchars($kategori['nama_kategori'], ENT_QUOTES) . 
                                    "</option>";
                            }
                        } else {
                            echo "<option value=''>No categories available</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Foto Produk</label>
                    <?php if (!empty($gambar['gambar'])): ?>
                        <p>Foto saat ini:</p>
                        <img src="../uploads/<?php echo htmlspecialchars($gambar['gambar'], ENT_QUOTES); ?>" alt="Current Photo" style="max-width: 200px; max-height: 200px;">
                    <?php endif; ?>
                    <p>Foto produk baru:</p>
                    <input type="file" name="gambar" class="form-control">
                </div>
                <br>
                <div class="form-group text-end">
                    <button type="submit" name="submit" class="btn btn-primary btn-sm rounded">Save Changes</button>
                </div>
            </div>
        </div>
    </section>
</form>

<script src="../assets/js/vendors/jquery-3.6.0.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/select2.min.js"></script>
<script src="../assets/js/vendors/perfect-scrollbar.js"></script>
<script src="../assets/js/vendors/jquery.fullscreen.min.js"></script>
<script src="../assets/js/main.js" type="text/javascript"></script>
</body>
</html>
