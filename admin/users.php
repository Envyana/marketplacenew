<?php
include 'koneksi.php';

// Query untuk mengambil semua data dari tabel seller
$query = "SELECT user_id, username, email, password, alamat, NoHp, created_at FROM users";
$result = mysqli_query($koneksi, $query);

// Periksa apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi)); 
}

// Pastikan data yang diambil tidak kosong
if (mysqli_num_rows($result) > 0) {
    // Simpan data ke array untuk digunakan nanti
    $seller = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $seller = []; // Jika tidak ada data, buat array kosong
}

mysqli_close($koneksi); // Tutup koneksi database setelah selesai
?>
<section class="content-main">
                <div class="content-header">
                    <h2 class="content-title">Daftar Pembeli</h2>
                </div>
                        <!-- card-header end// -->
                        <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID User</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Alamat</th>
                                    <th>Nomor Hp</th>
                                    <th>Dibuat pada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($seller as $row): ?>
                                <tr>
                                    <td><?php echo $row['user_id']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['password']; ?></td>
                                    <td><?php echo $row['alamat']; ?></td>
                                    <td><?php echo $row['NoHp']; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
</section>
        <script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
        <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
        <script src="assets/js/vendors/select2.min.js"></script>
        <script src="assets/js/vendors/perfect-scrollbar.js"></script>
        <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
        <!-- Main Script -->
        <script src="assets/js/main.js?v=1.1" type="text/javascript"></script>
    </body>
</html>