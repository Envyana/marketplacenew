<?php
include 'koneksi.php';

// Query untuk mengambil semua data dari tabel admin
$query = "SELECT id, username, password, nama FROM admin";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi)); // Menampilkan error jika query gagal
}

if (mysqli_num_rows($result) > 0) {
    // Inisialisasi nomor urut
    $nomor = 1;
?>
<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Admin List</h2>
        </div>
        <div>
            <a href="utama.php?page=profile" class="btn btn-primary btn-sm rounded">Create new</a>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Menampilkan data admin dengan penomoran dinamis
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td><?php echo $nomor++; ?></td>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['password']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td>
                                <a href="utama.php?page=editprofile&id=<?php echo $row['id']; ?>" class="btn btn-sm font-sm rounded btn-brand">
                                    <i class="material-icons md-edit"></i> Edit 
                                </a>
                                <a href="deleteadmin.php?id=<?php echo $row['id']; ?>" class="btn btn-sm font-sm btn-light rounded" onclick="return confirm('Are you sure you want to delete this admin?');">
                                    <i class="material-icons md-delete_forever"></i> Delete 
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php
} else {
    echo "Data tidak ditemukan.";
}
?>
<script src="../assets/js/vendors/jquery-3.6.0.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/select2.min.js"></script>
<script src="../assets/js/vendors/perfect-scrollbar.js"></script>
<script src="../assets/js/vendors/jquery.fullscreen.min.js"></script>
<script src="../assets/js/main.js" type="text/javascript"></script>
</body>
</html>
