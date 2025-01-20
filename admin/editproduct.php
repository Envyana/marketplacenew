<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Query untuk mengambil data produk berdasarkan ID
    $query = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Produk tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $ukuran = mysqli_real_escape_string($koneksi, $_POST['ukuran']);
    $warna = mysqli_real_escape_string($koneksi, $_POST['warna']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $ketersediaan_stok = mysqli_real_escape_string($koneksi, $_POST['ketersediaan_stok']);
    $berat = mysqli_real_escape_string($koneksi, $_POST['berat']);
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    
    // Menangani upload gambar
    $gambar_baru = $_FILES['gambar']['name'];
    $gambar_lama = $row['gambar'];

    // Jika gambar baru diupload
    if ($gambar_baru != '') {
        $target_dir = "../upload/";
        $target_file = $target_dir . basename($gambar_baru);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file adalah gambar yang valid
        $valid_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $valid_extensions)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit;
        }

        // Cek apakah file sudah ada
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            exit;
        }

        // Upload file gambar
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Update produk dengan gambar baru
            $update_query = "UPDATE produk SET 
                                nama_produk = '$nama_produk',
                                deskripsi = '$deskripsi',
                                warna = '$warna',
                                ukuran = '$ukuran',
                                harga = '$harga',
                                ketersediaan_stok = '$ketersediaan_stok',
                                berat = '$berat',
                                id_kategori = '$id_kategori',
                                gambar = '$gambar_baru'
                            WHERE id_produk = '$id_produk'";
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $update_query = "UPDATE produk SET 
                            nama_produk = '$nama_produk',
                            deskripsi = '$deskripsi',
                            warna = '$warna',
                            ukuran = '$ukuran',
                            harga = '$harga',
                            ketersediaan_stok = '$ketersediaan_stok',
                            berat = '$berat',
                            id_kategori = '$id_kategori'
                        WHERE id_produk = '$id_produk'";
    }

    // Eksekusi query update produk
    if (mysqli_query($koneksi, $update_query)) {
        header("Location: utama.php?page=product");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>

<!-- HTML Form untuk edit produk -->
<form action="editproduct.php?id=<?php echo $id_produk; ?>" method="post" enctype="multipart/form-data">
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Edit Produk</h2>
            </div>
            <div>
                <a href="utama.php?page=product" class="btn btn-secondary btn-sm rounded">Kembali Ke List Produk</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
            <div class="form-group">
                    <label for="id_kategori">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-control" required>
                        <!-- Daftar kategori dari database -->
                        <?php
                        // Query untuk mendapatkan semua kategori
                        $kategori_query = "SELECT * FROM kategori";
                        $kategori_result = mysqli_query($koneksi, $kategori_query);

                        if ($kategori_result && mysqli_num_rows($kategori_result) > 0) {
                            while ($kategori = mysqli_fetch_assoc($kategori_result)) {
                                echo "<option value='" . $kategori['id_kategori'] . "' " . ($row['id_kategori'] == $kategori['id_kategori'] ? 'selected' : '') . ">" . htmlspecialchars($kategori['nama_kategori']) . "</option>";
                            }
                        } else {
                            echo "<option value=''>No categories available</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?php echo htmlspecialchars($row['nama_produk']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required><?php echo htmlspecialchars($row['deskripsi']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Ukuran</label>
                    <textarea name="ukuran" id="ukuran" class="form-control" rows="3" required><?php echo htmlspecialchars($row['ukuran']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Warna</label>
                    <textarea name="warna" id="warna" class="form-control" rows="3" required><?php echo htmlspecialchars($row['warna']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" class="form-control" value="<?php echo htmlspecialchars($row['harga']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="ketersediaan_stok">ketersediaan_stok</label>
                    <input type="number" name="ketersediaan_stok" id="ketersediaan_stok" class="form-control" value="<?php echo htmlspecialchars($row['ketersediaan_stok']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="berat">Berat (gram)</label>
                    <input type="number" name="berat" id="berat" class="form-control" value="<?php echo htmlspecialchars($row['berat']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar Produk</label>
                    <!-- Menampilkan gambar lama jika ada -->
                    <div>
                        <?php if (!empty($row['gambar']) && file_exists("../upload/" . $row['gambar'])) { ?>
                            <img src="../upload/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Product Image" class="img-fluid" style="max-width: 100px; height: auto;">
                        <?php } else { ?>
                            <img src="../assets/images/no-image.png" alt="No image available" class="img-fluid" style="max-width: 100px; height: auto;">
                        <?php } ?>
                    </div>
                    <input type="file" name="gambar" id="gambar" class="form-control mt-2">
                    <small class="form-text text-muted">Biarkan Kosong jika Anda tidak ingin mengubah gambar.</small>
                </div>
                <div class="form-group text-end">
                    <button type="submit" class="btn btn-primary btn-sm rounded">Simpan Perubahan</button>
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
