<?php
// Periksa apakah sesi sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'koneksi.php'; // Pastikan sudah terkoneksi ke database

// Pastikan session sudah aktif dan id_penjual ada
if (!isset($_SESSION['id_penjual'])) {
    die('<div style="color:red">Error: Anda belum login sebagai penjual. Harap login terlebih dahulu.</div>');
}

$id_penjual = $_SESSION['id_penjual']; // Ambil id_penjual dari session

// Mendefinisikan nomor produk secara dinamis
$query_count = "SELECT COUNT(*) AS total FROM produk WHERE id_penjual = '$id_penjual'";
$result_count = mysqli_query($koneksi, $query_count);
$row_count = mysqli_fetch_assoc($result_count);
$no = $row_count['total'] + 1;

// Menambahkan query untuk mengambil data kategori
$query_kategori = "SELECT id_kategori, nama_kategori FROM kategori";
$result_kategori = mysqli_query($koneksi, $query_kategori);

// Cek jika form dikirimkan
if (isset($_POST['submit'])) {
    // Mengambil data dari form dan melakukan sanitasi untuk mencegah SQL Injection
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $ukuran = mysqli_real_escape_string($koneksi, $_POST['ukuran']);
    $warna = mysqli_real_escape_string($koneksi, $_POST['warna']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $ketersediaan_stok = mysqli_real_escape_string($koneksi, $_POST['ketersediaan_stok']);
    
    // Proses upload gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "../upload/";
    $target_file = $target_dir . basename($gambar);
    
    // Validasi ekstensi file gambar
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_extension = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
    
    if (!in_array($file_extension, $allowed_extensions)) {
        echo '<div style="color:red">Format gambar tidak valid. Hanya file JPG, JPEG, PNG, GIF yang diperbolehkan.</div>';
    } else {
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Menambahkan data ke dalam tabel produk
            $query = "INSERT INTO produk (id_kategori, id_penjual, nama_produk, deskripsi, ukuran, warna, harga, ketersediaan_stok, gambar) 
                      VALUES ('$id_kategori', '$id_penjual', '$nama_produk', '$deskripsi', '$ukuran', '$warna', '$harga', '$ketersediaan_stok', '$gambar')";
            $result = mysqli_query($koneksi, $query);

            if ($result) {
                echo '<script>alert("Berhasil menambahkan produk."); document.location="utamapenjual.php?page=product";</script>';
            } else {
                // Tambahkan debug error
                echo '<div style="color:red">Gagal menambahkan produk. Error: ' . mysqli_error($koneksi) . '</div>';
            }
        } else {
            echo '<div style="color:red">Gagal mengupload gambar.</div>';
        }
    }
}
?>

<form action="utamapenjual.php?page=addproduct" method="post" enctype="multipart/form-data">
    <section class="content-main">
        <div class="row">
            <div class="col-9">
                <div class="content-header">
                    <h2 class="content-title">Tambah Produk Baru</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Basic Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="no" class="form-label">Nomor</label>
                            <input type="text" placeholder="Auto-generated number" class="form-control" value="<?php echo $no; ?>" disabled />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Kategori</label>
                            <select name="id_kategori" id="id_kategori" class="form-control" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <?php
                                // Menampilkan kategori dari hasil query
                                while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
                                    echo "<option value='" . htmlspecialchars($row_kategori['id_kategori']) . "'>" . htmlspecialchars($row_kategori['nama_kategori']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" placeholder="Enter product name" class="form-control" required />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" placeholder="Enter product description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Ukuran</label>
                            <textarea name="ukuran" placeholder="Enter product size" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Warna</label>
                            <textarea name="warna" placeholder="Enter product color" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" placeholder="Enter price" class="form-control" required />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Stok</label>
                            <input type="number" name="ketersediaan_stok" placeholder="Enter stock quantity" class="form-control" required />
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required />
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" name="submit" class="btn btn-md rounded font-sm hover-up">Simpan</button>
                    <a href="utamapenjual.php?page=product&id_penjual=<?php echo $id_penjual; ?>" class="btn btn-light rounded font-sm mr-5 text-body hover-up">Kembali</a>
                </div>
            </div>
        </div>
    </section>
</form>

<!-- content-main end// -->

<script src="../assets/js/vendors/jquery-3.6.0.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/select2.min.js"></script>
<script src="../assets/js/vendors/perfect-scrollbar.js"></script>
<script src="../assets/js/vendors/jquery.fullscreen.min.js"></script>
<!-- Main Script -->
<script src="../assets/js/main.js?v=1.1" type="text/javascript"></script>

</body>
</html>