<?php
include 'koneksi.php';

// Check if session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verify if seller is logged in
if (!isset($_SESSION['id_penjual'])) {
    die('<div class="alert alert-danger">Anda harus login untuk melakukan aksi ini.</div>');
}

// Get id_penjual from session and id_produk from URL
$id_penjual = $_SESSION['id_penjual'];
$id_produk = isset($_GET['id_produk']) ? $_GET['id_produk'] : null;

if ($id_produk) {
    // First, verify the product belongs to the logged in seller
    $verify_query = "SELECT * FROM produk WHERE id_produk = ? AND id_penjual = ?";
    $stmt = mysqli_prepare($koneksi, $verify_query);
    mysqli_stmt_bind_param($stmt, "ii", $id_produk, $id_penjual);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        
        if (!empty($row['gambar']) && file_exists("../upload/" . $row['gambar'])) {
            unlink("../upload/" . $row['gambar']);
        }

        
        $delete_query = "DELETE FROM produk WHERE id_produk = ? AND id_penjual = ?";
        $stmt = mysqli_prepare($koneksi, $delete_query);
        mysqli_stmt_bind_param($stmt, "ii", $id_produk, $id_penjual);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                    alert('Produk berhasil dihapus');
                    window.location.href='utamapenjual.php?page=product';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menghapus produk: " . mysqli_error($koneksi) . "');
                    window.location.href='utamapenjual.php?page=product';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Produk tidak ditemukan atau Anda tidak memiliki akses');
                window.location.href='utamapenjual.php?page=product';
              </script>";
    }
} else {
    echo "<script>
            alert('ID Produk tidak valid');
            window.location.href='utamapenjual.php?page=product';
          </script>";
}
?>