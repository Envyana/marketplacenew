<?php
include 'koneksi.php';

// Memeriksa apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id_penjual = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query untuk mengambil data seller berdasarkan ID
    $query = "SELECT * FROM seller WHERE id_penjual = '$id_penjual'";
    $result = mysqli_query($koneksi, $query);

    // Memeriksa apakah query berhasil dan data ditemukan
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Seller tidak ditemukan.";
        exit;
    }
} else {
    echo "ID penjual tidak tersedia.";
    exit;
}

// Memeriksa apakah form telah dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    // Query untuk memperbarui data seller
    $update_query = "UPDATE seller SET email = '$email' WHERE id_penjual = '$id_penjual'";

    if (mysqli_query($koneksi, $update_query)) {
        // Redirect ke halaman daftar seller setelah berhasil
        header("Location: utama.php?page=seller");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>

<!-- HTML Form untuk Edit Seller -->
<form action="edit_seller.php?id=<?php echo htmlspecialchars($id_penjual); ?>" method="post">
<form action="utama.php?page=addseller" method="post" enctype="multipart/form-data">
<section class="content-main">
    <div class="row">
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">Tambah Penjual Baru</h2>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Informasi Dasar</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Id Penjual</label>
                        <input type="text" name="id_penjual" placeholder="Masukkan ID penjual" class="form-control" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Toko</label>
                        <input type="email" name="toko placeholder="Masukkan nama toko" class="form-control" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" placeholder="Masukkan email" class="form-control" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Tanggal Terdaftar</label>
                        <input type="datetime-local" name="terdaftar" class="form-control" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Action</label>
                        <input type="text" name="action" placeholder="Masukkan tindakan" class="form-control" required />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Gambar</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*" required />
                    </div>
                </div>
            </div>
            <div>
                <button type="submit" name="submit" class="btn btn-md rounded font-sm hover-up">Simpan</button>
                <a href="utama.php?page=seller" class="btn btn-light rounded font-sm mr-5 text-body hover-up">Kembali</a>
            </div>
        </div>
    </div>
</section>
</form>

<!-- Scripts -->
<script src="../assets/js/vendors/jquery-3.6.0.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/select2.min.js"></script>
<script src="../assets/js/vendors/perfect-scrollbar.js"></script>
<script src="../assets/js/vendors/jquery.fullscreen.min.js"></script>
<script src="../assets/js/main.js" type="text/javascript"></script>
</body>
</html>
