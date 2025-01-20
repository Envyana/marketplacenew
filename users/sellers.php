<?php
include 'config.php';

// Query untuk mengambil semua data dari tabel seller
$query = "SELECT id_penjual, toko, email, status, registered, action, gambar FROM seller";
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
                    <h2 class="content-title">List Penjual</h2>
                    <div>
                        <a href="utama.php?page=addseller" class="btn btn-primary"><i class="material-icons md-plus"></i> Create new</a>
                    </div>
                </div>
                <div class="card mb-4">
                    <header class="card-header">
                        <div class="row gx-3">
                            <div class="col-lg-4 col-md-6 me-auto">
                                <input type="text" placeholder="Search..." class="form-control" />
                            </div>
                            <div class="col-lg-2 col-md-3 col-6">
                                <select class="form-select">
                                    <option>Status</option>
                                    <option>Active</option>
                                    <option>Inactive</option>
                                    <option>Show all</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-6">
                                <select class="form-select">
                                    <option>Show 20</option>
                                    <option>Show 30</option>
                                    <option>Show 40</option>
                                </select>
                            </div>
                        </div>
                    </header>
                        <!-- card-header end// -->
                        <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID Seller</th>
                                    <th>Toko</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                    <th class="text-end">Action</th> <!-- Kolom untuk tombol Edit/Delete -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($seller as $row): ?>
                                <tr>
                                    <td><?php echo $row['id_penjual']; ?></td>
                                    <td><?php echo $row['toko']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><?php echo $row['registered']; ?></td>
                                    <td><?php echo $row['gambar']; ?></td>
                                    <td class="text-end">
                                        <!-- Tambahkan tombol Edit -->
                                        <a href="utama.php?page=edit_seller&id=<?php echo $row['id_penjual']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <!-- Opsional: Tambahkan tombol Delete -->
                                        <a href="utama.php?page=delete_seller&id_penjual=<?php echo $row['id_penjual']; ?>" class="btn btn-sm btn-primary">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
</section>
            <!-- content-main end// -->
            <footer class="main-footer font-xs">
                <div class="row pb-30 pt-15">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        &copy; Manik La Magie
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end">All rights reserved</div>
                    </div>
                </div>
            </footer>
        </main>
        <script src="assets/js/vendors/jquery-3.6.0.min.js"></script>
        <script src="assets/js/vendors/bootstrap.bundle.min.js"></script>
        <script src="assets/js/vendors/select2.min.js"></script>
        <script src="assets/js/vendors/perfect-scrollbar.js"></script>
        <script src="assets/js/vendors/jquery.fullscreen.min.js"></script>
        <!-- Main Script -->
        <script src="assets/js/main.js?v=1.1" type="text/javascript"></script>
    </body>
</html>