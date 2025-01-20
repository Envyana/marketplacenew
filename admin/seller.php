<?php
include 'koneksi.php'; // Koneksi database

// Query untuk mengambil data penjual
$query_penjual = "SELECT id_penjual, toko, email, status, registered, gambar FROM seller";
$result_penjual = mysqli_query($koneksi, $query_penjual);

if (!$result_penjual) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<section class="content-main">
    <div class="row">
        <div class="col-12">
        </div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Daftar Penjual</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Penjual</th>
                                    <th>Toko</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Terdaftar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if (mysqli_num_rows($result_penjual) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_penjual)) {
                                        // Path ke folder uploads
                                        $upload_path = "uploads/";
                                        $default_image = "uploads/default_image.png"; // Pastikan default_image.png ada di folder uploads

                                        // Cek apakah file gambar ada dan valid
                                        $gambar = (!empty($row['gambar']) && file_exists($upload_path . $row['gambar'])) 
                                            ? $upload_path . $row['gambar'] 
                                            : $default_image;

                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['id_penjual']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['toko']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                        echo "<td>" . date('d M Y, H:i', strtotime($row['registered'])) . "</td>";
                                        echo "<td>
                                                <a href='utama.php?page=seller_detail&id=" . htmlspecialchars($row['id_penjual']) . "' class='btn btn-sm btn-brand'>Detail</a>
                                                <a href='utama.php?page=delete_seller&id_penjual=" . htmlspecialchars($row['id_penjual']) . "' onclick='return confirm(\"Are you sure you want to delete this seller?\");' class='btn btn-sm btn-light'>Hapus</a>
                                            </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>No sellers found</td></tr>";
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
