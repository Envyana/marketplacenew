<?php
include 'koneksi.php'; // Pastikan koneksi database

// Ambil ID penjual dari URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Query untuk mengambil data penjual berdasarkan ID
    $query_users = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result_users = mysqli_query($koneksi, $query_users);
    $users = mysqli_fetch_assoc($result_users);

    if (!$users) {
        echo "<script>alert('Seller not found!'); window.location='utama.php?page=users';</script>";
        exit;
    }

    // Query untuk mengambil produk yang terkait dengan penjual
    $query_produk = "SELECT id_produk, nama_produk, deskripsi, harga, stok, gambar, ukuran 
                     FROM produk 
                     WHERE id_penjual = '$id_penjual'";
    $result_produk = mysqli_query($koneksi, $query_produk);
} else {
    echo "<script>alert('ID Penjual gagal diproses!'); window.location='utama.php?page=users';</script>";
    exit;
}
?>

<section class="content-main">
    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h2 class="content-title"><?php echo htmlspecialchars($users['username']); ?></h2>
                <a href="utama.php?page=users" class="btn btn-primary">Kembali ke daftar penjual</a>
            </div>
        </div>

        <!-- Detail Penjual -->
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Detail Penjual</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td><?php echo htmlspecialchars($users['user_id']); ?></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td><?php echo htmlspecialchars($users['username']); ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($users['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td><?php echo htmlspecialchars($users['password']); ?></td>
                        </tr>
                            <th>Nama Toko</th>
                            <td><?php echo htmlspecialchars($users['toko']); ?></td>
                        </tr>
                        <tr>
                            <th>Terdaftar</th>
                            <td><?php echo htmlspecialchars($users['registered']); ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?php echo htmlspecialchars($users['status']); ?></td>
                        </tr>
                        <tr>
                            <th>Profil</th>
                            <td><?php echo htmlspecialchars($users['gambar']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Produk Penjual -->
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Produk dari <?php echo htmlspecialchars($users['toko']); ?></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Foto Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Dekripsi</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Query ke database
                            $id_produk = 1; // Ganti dengan ID toko sesuai kebutuhan
                            $query = "SELECT * FROM produk WHERE id_produk = $id_produk"; // Sesuaikan dengan tabel dan parameter Anda
                            $result_produk = mysqli_query($koneksi, $query);

                            if (!$result_produk) {
                                die("Query gagal: " . mysqli_error($koneksi));
                            }

                            // Tampilkan data produk
                            if (mysqli_num_rows($result_produk) > 0) {
                                while ($produk = mysqli_fetch_assoc($result_produk)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($produk['id_produk']) . "</td>";
                                    echo "<td>";
                                    if (!empty($produk['gambar']) && file_exists("../upload/" . $produk['gambar'])) {
                                        echo "<img src='../upload/" . htmlspecialchars($produk['gambar']) . "' alt='" . htmlspecialchars($produk['nama_produk']) . "' style='max-width: 100px;'>";
                                    } else {
                                        echo "<img src='../assets/images/no-image.png' alt='No image available' style='max-width: 100px;'>";
                                    }
                                    echo "</td>";
                                    echo "<td>" . htmlspecialchars($produk['nama_produk']) . "</td>";
                                    echo "<td>" . htmlspecialchars($produk['deskripsi']) . "</td>";
                                    echo "<td>Rp " . number_format($produk['harga'], 0, ',', '.') . "</td>";
                                    echo "<td>" . htmlspecialchars($produk['ketersediaan_stok']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No products found</td></tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="../assets/js/vendors/jquery-3.6.0.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/select2.min.js"></script>
<script src="../assets/js/vendors/perfect-scrollbar.js"></script>
<script src="../assets/js/vendors/jquery.fullscreen.min.js"></script>
<script src="../assets/js/main.js?v=1.1"></script>