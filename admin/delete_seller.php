<?php
include 'koneksi.php';

// Memeriksa apakah parameter 'id_penjual' ada di URL
if (isset($_GET['id_penjual'])) {
    $id_penjual = mysqli_real_escape_string($koneksi, $_GET['id_penjual']); // Escape input untuk keamanan

    // Query untuk mengambil data seller berdasarkan ID
    $query = "SELECT * FROM seller WHERE id_penjual = '$id_penjual'";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query SELECT gagal: " . mysqli_error($koneksi)); // Debug jika SELECT gagal
    }

    if (mysqli_num_rows($result) > 0) {
        // Mengambil data seller yang akan dihapus
        $row = mysqli_fetch_assoc($result);

        // Menghapus gambar seller jika ada
        if (!empty($row['gambar']) && file_exists("../upload/" . $row['gambar'])) {
            if (!unlink("../upload/" . $row['gambar'])) {
                echo "<script>alert('Gagal menghapus file gambar.');</script>";
            }
        }

        // Query untuk menghapus seller dari tabel
        $delete_query = "DELETE FROM seller WHERE id_penjual = '$id_penjual'";

        if (mysqli_query($koneksi, $delete_query)) {
            // Jika berhasil dihapus, arahkan ke halaman seller list
            echo "<script>alert('Seller berhasil dihapus.'); window.location='utama.php?page=seller';</script>";
            exit;
        } else {
            // Jika query gagal, tampilkan pesan error
            echo "<script>alert('Error menghapus seller: " . mysqli_error($koneksi) . "');</script>";
        }
    } else {
        echo "<script>alert('Seller tidak ditemukan.'); window.location='utama.php?page=seller';</script>";
    }
} else {
    echo "<script>alert('ID Penjual tidak tersedia.'); window.location='utama.php?page=seller';</script>";
}

mysqli_close($koneksi); // Tutup koneksi database
?>
