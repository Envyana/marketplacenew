<?php
if (isset($_POST['submit'])) {
    // Validasi login
    if (!isset($_SESSION['username'])) {
        die('<div style="color:red">Error: Anda belum login sebagai penjual. Harap login terlebih dahulu.</div>');
    }

    // Ambil id_penjual dari sesi
    $username = $_SESSION['username'];
    $result = mysqli_query($koneksi, "SELECT id_penjual FROM seller WHERE username = '$username'");
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        die('<div style="color:red">Error: Akun Anda tidak terdaftar sebagai penjual. Harap hubungi admin.</div>');
    }
    $id_penjual = $row['id_penjual'];

    // Lanjutkan proses
    $nama_produk = $_POST['nama_produk'];
    $id_kategori = $_POST['id_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $ketersediaan_stok = $_POST['ketersediaan_stok'];
    $warna = $_POST['warna'];
    $ukuran = $_POST['ukuran'];

    // Proses upload gambar
    $target_dir = "../upload/";
    $file_name = basename($_FILES["product_image"]["name"]);
    $target_file = $target_dir . $file_name;

    // Validasi gambar
    $uploadOk = 1;
    $check = getimagesize($_FILES["product_image"]["tmp_name"]);
    if ($check === false) {
        echo '<div class="alert alert-error">File bukan gambar yang valid</div>';
        $uploadOk = 0;
    }

    if ($uploadOk && move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        $sql = mysqli_query($koneksi, "INSERT INTO produk (id_kategori, nama_produk, deskripsi, harga, ketersediaan_stok, warna, ukuran, gambar, id_penjual) 
        VALUES ('$id_kategori', '$nama_produk', '$deskripsi', '$harga', '$ketersediaan_stok', '$warna', '$ukuran', '$file_name', '$id_penjual')") 
        or die(mysqli_error($koneksi));

        if ($sql) {
            echo '<div class="alert alert-success">Produk berhasil ditambahkan</div>';
        } else {
            echo '<div class="alert alert-error">Gagal menambahkan produk</div>';
        }
    } else {
        echo '<div class="alert alert-error">Gagal mengupload gambar</div>';
    }
}
?>

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title card-title">Add New Product</h2>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h4>Basic</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="nama_produk" class="form-label">Nama Produk</label>
                    <input type="text" placeholder="Masukkan nama produk" required class="form-control" name="nama_produk" />
                </div>

                <div class="mb-4">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select" required>
                        <?php
                        $kategori_query = mysqli_query($koneksi, "SELECT * FROM kategori");
                        while ($kategori = mysqli_fetch_assoc($kategori_query)) {
                            echo "<option value='" . $kategori['id_kategori'] . "'>" . $kategori['nama_kategori'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea placeholder="Masukkan deskripsi produk" required class="form-control" name="deskripsi"></textarea>
                </div>

                <div class="mb-4">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="text" placeholder="Masukkan harga produk" required class="form-control" name="harga" />
                </div>

                <div class="mb-4">
                    <label for="ketersediaan_stok" class="form-label">Stok</label>
                    <input type="text" placeholder="Masukkan stok produk" required class="form-control" name="ketersediaan_stok" />
                </div>

                <div class="mb-4">
                    <label for="warna" class="form-label">Warna</label>
                    <input type="text" name="warna" class="form-control" required />
                </div>

                <div class="mb-4">
                    <label for="ukuran" class="form-label">Ukuran</label>
                    <input type="text" name="ukuran" class="form-control" required />
                </div>

                <div class="mb-4">
                    <label for="product_image" class="form-label">Gambar Produk</label>
                    <input type="file" name="product_image" class="form-control" required />
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" name="submit" class="btn btn-primary rounded font-sm">Add Product</button>
                    <a href="utama.php?page=product" class="btn btn-light rounded font-sm text-body">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</section>
