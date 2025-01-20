<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_kategori = $_GET['id'];

    // Query untuk mengambil data kategori berdasarkan ID
    $query = "SELECT * FROM kategori WHERE id_kategori = '$id_kategori'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Kategori tidak ditemukan.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    
    // Query untuk update kategori
    $update_query = "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id_kategori = '$id_kategori'";
    
    if (mysqli_query($koneksi, $update_query)) {
        header("Location: utama.php?page=categories");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>

<!-- HTML Form untuk edit kategori -->
<form action="editcategories.php?id=<?php echo $id_kategori; ?>" method="post">
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Edit Kategori</h2>
            </div>
            <div>
                <a href="utama.php?page=categories" class="btn btn-secondary btn-sm rounded">Kembali Ke Kategori</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="<?php echo htmlspecialchars($row['nama_kategori']); ?>" required>
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
