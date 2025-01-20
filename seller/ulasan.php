<?php
include 'koneksi.php'; // Koneksi ke database

// Cek apakah session sudah dimulai, jika belum maka jalankan session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mendapatkan username atau id_penjual yang sedang login
$username = $_SESSION['username']; // Misalnya username disimpan di session
// Atau jika menggunakan id_penjual yang di session
$id_penjual = $_SESSION['id_penjual']; 

// Query untuk mengambil data ulasan dari database
$query_ulasan = "
    SELECT 
        ulasan.id_ulasan, 
        produk.nama_produk, 
        users.username AS username, 
        ulasan.rating, 
        ulasan.komentar, 
        ulasan.tanggal,
        seller.toko AS nama_penjual,
        produk.gambar
    FROM ulasan
    JOIN produk ON ulasan.id_produk = produk.id_produk
    JOIN users ON ulasan.user_id = users.user_id
    JOIN seller ON produk.id_penjual = seller.id_penjual
    WHERE seller.username = '$username'  -- Menambahkan filter berdasarkan username penjual yang sedang login
    -- Atau bisa pakai filter id_penjual jika sudah menggunakan session id_penjual
    -- WHERE produk.id_penjual = '$id_penjual'
";

$result_ulasan = mysqli_query($koneksi, $query_ulasan);

if (!$result_ulasan) {
    die("Query error: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($result_ulasan) > 0) { // Periksa apakah ada ulasan
    $nomor = 1; // Inisialisasi nomor urut
    ?>
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Ulasan</h2>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Nama Penjual</th>
                            <th>Nama Pembeli</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Tanggal ulasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result_ulasan)) {
                            // Menentukan jumlah bintang yang aktif berdasarkan rating
                            $rating_percentage = ($row['rating'] / 5) * 100; // Misalnya rating maksimal adalah 5
                        ?>
                        <tr>
                            <td><?php echo $nomor++; ?></td>
                            <td>
                                <img src="../upload/<?php echo $row['gambar']; ?>" alt="gambar" style="width: 50px; height: 50px; object-fit: cover;" /> <!-- Menampilkan Foto Produk -->
                            </td>
                            <td><b><?php echo $row['nama_produk']; ?></b></td>
                            <td><?php echo $row['nama_penjual']; ?></td> <!-- Menampilkan Nama Penjual -->
                            <td><?php echo $row['username']; ?></td>
                            <td>
                                <ul class="rating-stars">
                                    <li style="width: <?php echo $rating_percentage; ?>%" class="stars-active">
                                        <img src="../assets/imgs/icons/stars-active.svg" alt="stars" />
                                    </li>
                                    <li>
                                        <img src="../assets/imgs/icons/starts-disable.svg" alt="stars" />
                                    </li>
                                </ul>
                            </td>
                            <td><?php echo $row['komentar']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php
} else {
    echo "<div class='alert alert-warning'>Tidak ada ulasan yang tersedia.</div>";
}
?>