<?php
include('koneksi.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Mendapatkan username pengguna

// Mengambil data keranjang dari database berdasarkan username
$query = "
    SELECT 
        c.id_keranjang, 
        c.id_produk, 
        p.nama_produk, 
        p.harga, 
        c.quantity, 
        p.gambar, 
        c.created_at,
        c.is_selected 
    FROM cart c 
    JOIN produk p ON c.id_produk = p.id_produk 
    WHERE c.username = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_price = 0;
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    if ($row['is_selected']) {
        $total_price += $row['harga'] * $row['quantity'];
    }
}

// Proses pembaruan kuantitas produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $id_keranjang => $quantity) {
        $quantity = intval($quantity);
        if ($quantity > 0) {
            // Perbarui kuantitas di database
            $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id_keranjang = ?");
            $update_stmt->bind_param("ii", $quantity, $id_keranjang);
            $update_stmt->execute();
        } else {
            // Hapus produk dari keranjang jika kuantitas = 0
            $delete_stmt = $conn->prepare("DELETE FROM cart WHERE id_keranjang = ?");
            $delete_stmt->bind_param("i", $id_keranjang);
            $delete_stmt->execute();
        }
    }

    // Redirect ke halaman keranjang
    header("Location: utama.php?page=keranjang");
    exit();
}

// Proses penghapusan produk berdasarkan ID keranjang
if (isset($_GET['remove_id'])) {
    $id_keranjang = intval($_GET['remove_id']);
    $delete_stmt = $conn->prepare("DELETE FROM cart WHERE id_keranjang = ?");
    $delete_stmt->bind_param("i", $id_keranjang);
    $delete_stmt->execute();

    // Redirect ke halaman keranjang
    header("Location: utama.php?page=keranjang");
    exit();
}

// Tambahkan handler untuk toggle selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_selection'])) {
    $id_keranjang = intval($_POST['toggle_selection']);
    $is_selected = isset($_POST['is_selected']) ? 1 : 0;
    
    $update_stmt = $conn->prepare("UPDATE cart SET is_selected = ? WHERE id_keranjang = ?");
    $update_stmt->bind_param("ii", $is_selected, $id_keranjang);
    $update_stmt->execute();
    
    // Redirect kembali ke keranjang
    header("Location: utama.php?page=keranjang");
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="styles.css"> <!-- Tambahkan CSS yang sesuai -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Bagian Keranjang -->
    <div class="row row-pb-lg">
        <div class="col-md-12">
            <form action="keranjang.php" method="POST">
                <div class="product-name d-flex">
                    <div class="one-forth text-left px-4">
                        <span>Product Details</span>
                    </div>
                    <div class="one-eight text-center">
                        <span>Price</span>
                    </div>
                    <div class="one-eight text-center">
                        <span>Quantity</span>
                    </div>
                    <div class="one-eight text-center">
                        <span>Total</span>
                    </div>
                    <div class="one-eight text-center px-4">
                        <span>Remove</span>
                    </div>
                </div>

                <?php if (!empty($cart_items)): ?>
                    <?php foreach ($cart_items as $item): ?>
                        <?php 
                            $product_total = $item['harga'] * $item['quantity']; 
                        ?>
                        <div class="product-cart d-flex">
                            <div class="one-forth">
                            <div class="product-img" 
                            
                            style="background-image: url('<?php echo isset($item['gambar']) && file_exists('../upload/' . $item['gambar']) ? '../upload/' . htmlspecialchars($item['gambar']) : ''; ?>');
                                    margin-left: 20px; /* Geser 20px ke kanan */
                                    background-size: cover; 
                                    background-position: center;">
                        </div>


                                <div class="display-tc text-center">
                                    <h3><?php echo htmlspecialchars($item['nama_produk']); ?></h3>
                                </div>
                            </div>
                            <div class="one-eight text-center">
                                <div class="display-tc">
                                    <span class="price">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></span>
                                    <input type="checkbox" 
                                           class="item-checkbox"
                                           data-id="<?php echo $item['id_keranjang']; ?>"
                                           <?php echo $item['is_selected'] ? 'checked' : ''; ?>
                                           style="margin-left: 10px;">
                                </div>
                            </div>
                            <div class="one-eight text-center">
                                <div class="display-tc">
                                    <input type="number" name="quantity[<?php echo $item['id_keranjang']; ?>]" class="form-control input-number text-center" value="<?php echo $item['quantity']; ?>" min="1" max="100">
                                </div>
                            </div>
                            <div class="one-eight text-center">
                                <div class="display-tc">
                                    <span class="price">Rp <?php echo number_format($product_total, 0, ',', '.'); ?></span>
                                </div>
                            </div>
                            <div class="one-eight text-center">
                                <div class="display-tc">
                                    <a href="keranjang.php?remove_id=<?php echo $item['id_keranjang']; ?>" class="closed">Hapus</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Keranjang kosong.</p>
                <?php endif; ?>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">Perbarui Keranjang</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bagian Total Harga -->
    <div class="row row-pb-lg">
        <div class="col-md-12">
            <div class="total-wrap">
                <div class="row">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-4 text-center">
                        <div class="total">
                            <div class="sub">
                                <p><span>Subtotal:</span> <span>Rp <?php echo number_format($total_price, 0, ',', '.'); ?></span></p>
                                <p><span>Delivery:</span> <span>Rp 0</span></p>
                            </div>
                            <div class="grand-total">
                                <p><span><strong>Total:</strong></span> <span>Rp <?php echo number_format($total_price, 0, ',', '.'); ?></span></p>
                            </div>
                            <div class="checkout-btn">
                                <form action="utama.php?page=checkout" method="POST">
                                    <button type="submit" class="btn btn-success">Checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('.item-checkbox').change(function() {
            const id_keranjang = $(this).data('id');
            const is_selected = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                url: 'toggle_selection.php',
                type: 'POST',
                data: {
                    toggle_selection: id_keranjang,
                    is_selected: is_selected
                },
                success: function(response) {
                    // Hitung ulang total
                    let total = 0;
                    $('.item-checkbox:checked').each(function() {
                        const row = $(this).closest('.product-cart');
                        const price = parseFloat(row.find('.price').text().replace('Rp ', '').replace('.', ''));
                        const quantity = parseInt(row.find('input[type="number"]').val());
                        total += price * quantity;
                    });

                    // Update tampilan total
                    $('.grand-total span:last').text('Rp ' + total.toLocaleString('id-ID'));
                    $('.sub p:first span:last').text('Rp ' + total.toLocaleString('id-ID'));
                },
                error: function() {
                    alert('Terjadi kesalahan saat memperbarui seleksi');
                }
            });
        });
    });
    </script>
</body>
</html>
