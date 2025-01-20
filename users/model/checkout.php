<?php
include('koneksi.php'); // Sambungkan ke database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Username pengguna yang login

// Ambil data keranjang dari database berdasarkan username
$query = "
    SELECT 
        c.id_produk, 
        p.nama_produk AS name, 
        p.harga AS price, 
        c.quantity, 
        p.gambar 
    FROM cart c 
    JOIN produk p ON c.id_produk = p.id_produk 
    WHERE c.username = ? AND c.is_selected = 1
";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_price = 0;

// Menghitung total harga dan mengumpulkan data keranjang
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total_price += $row['price'] * $row['quantity'];
}

// Redirect jika keranjang kosong
if (empty($cart_items)) {
    header("Location: utama.php?page=keranjang");
    exit();
}

// API Key RajaOngkir
$apiKey = 'ab636aae726a4a78f4153c5518e6af60'; // Ganti dengan API Key Anda

// Fungsi untuk mengambil data dari API RajaOngkir
function getDataFromRajaOngkir($url, $apiKey) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "key: $apiKey"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

// Ambil daftar provinsi
$provinces = getDataFromRajaOngkir('https://api.rajaongkir.com/starter/province', $apiKey);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout & Cek Ongkir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Detail Belanja Anda</h2>

        <!-- Tabel Produk di Keranjang -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td>
                            <img src="../upload/<?= htmlspecialchars($item['gambar']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width: 100px;">
                        </td>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>Rp<?= number_format($item['price'], 2, ',', '.') ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>Rp<?= number_format($item['price'] * $item['quantity'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Total Harga -->
        <div class="text-right mt-4">
            <h4>Total Harga: Rp<?= number_format($total_price, 2, ',', '.') ?></h4>
        </div>

        <!-- Form Checkout dan Cek Ongkir -->
        <form action="utama.php?page=proses_checkout.php" method="POST">
            <input type="hidden" name="total_price" id="total-price-hidden" value="<?= $total_price ?>">

            <h4 class="mt-4">Data Pengiriman</h4>
            <div class="form-group">
                <label for="customer_name">Nama Lengkap:</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="customer_phone">Nomor Telepon:</label>
                <input type="text" name="customer_phone" id="customer_phone" class="form-control" required>
            </div>

            <h4 class="mt-4">Cek Ongkir</h4>
            <div class="form-group">
                <label for="origin-province">Provinsi Asal:</label>
                <select id="origin-province" name="origin_province" class="form-control" required>
                    <option value="">Pilih Provinsi</option>
                    <?php foreach ($provinces['rajaongkir']['results'] as $province): ?>
                        <option value="<?= $province['province_id'] ?>"><?= $province['province'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="origin-city">Kota Asal:</label>
                <select id="origin-city" name="origin_city" class="form-control" required></select>
            </div>
            <div class="form-group">
                <label for="destination-province">Provinsi Tujuan:</label>
                <select id="destination-province" name="destination_province" class="form-control" required>
                    <option value="">Pilih Provinsi</option>
                    <?php foreach ($provinces['rajaongkir']['results'] as $province): ?>
                        <option value="<?= $province['province_id'] ?>"><?= $province['province'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="destination-city">Kota Tujuan:</label>
                <select id="destination-city" name="destination_city" class="form-control" required></select>
            </div>
            <div class="form-group">
                <label for="customer_address">Alamat Lengkap:</label>
                <textarea name="customer_address" id="customer_address" class="form-control" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="weight">Berat Barang (gram):</label>
                <input type="number" name="weight" id="weight" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="courier">Kurir:</label>
                <select name="courier" id="courier" class="form-control" required>
                    <option value="">Pilih Kurir</option>
                    <option value="jne">JNE</option>
                    <option value="pos">POS</option>
                    <option value="tiki">TIKI</option>
                </select>
            </div>

            <!-- Opsi Ongkir (Checkbox) -->
            <div class="form-group mt-3">
                <button type="button" id="cekOngkirBtn" class="btn btn-primary">Cek Ongkir</button>
            </div>
            <div id="ongkirResult" class="mt-3"></div>

            <!-- Total Ongkir dan Harga Akhir -->
            <div class="form-group mt-3">
                <label for="ongkirTotal">Total Ongkir:</label>
                <p id="ongkir-total">Rp 0</p>
            </div>
            <div class="form-group mt-3">
                <label for="finalTotal">Total Harga Akhir:</label>
                <p id="final-total">Rp <?= number_format($total_price, 2, ',', '.') ?></p>
            </div>

            <button type="submit" class="btn btn-success mt-3">Checkout</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadCities(provinceId, targetSelect) {
            if (provinceId) {
                $.ajax({
                    url: 'kota.php',
                    type: 'POST',
                    data: { province_id: provinceId },
                    success: function(data) {
                        $(targetSelect).html(data);
                    }
                });
            }
        }

        $('#origin-province').change(function() {
            loadCities($(this).val(), '#origin-city');
        });

        $('#destination-province').change(function() {
            loadCities($(this).val(), '#destination-city');
        });

        $('#cekOngkirBtn').click(function() {
            const originCity = $('#origin-city').val();
            const destinationCity = $('#destination-city').val();
            const weight = $('#weight').val();
            const courier = $('#courier').val();

            if (!originCity || !destinationCity || !weight || !courier) {
                alert('Lengkapi semua data pengiriman!');
                return;
            }

            $.ajax({
                url: 'cek_ongkir.php',
                type: 'POST',
                data: {
                    origin_city: originCity,
                    destination_city: destinationCity,
                    weight: weight,
                    courier: courier,
                },
                success: function(data) {
                    $('#ongkirResult').html(data);
                    updateTotalPrice();
                },
                error: function() {
                    $('#ongkirResult').html('<p class="text-danger">Gagal memproses data ongkir!</p>');
                }
            });
        });

        // Fungsi untuk menghitung total harga setelah memilih ongkir
        function updateTotalPrice() {
            let totalOngkir = 0;
            $('.ongkir-option:checked').each(function() {
                totalOngkir += parseInt($(this).val());
            });

            const totalPrice = <?= $total_price ?>;
            const finalTotal = totalPrice + totalOngkir;

            $('#ongkir-total').text('Rp ' + new Intl.NumberFormat('id-ID').format(totalOngkir));
            $('#final-total').text('Rp ' + new Intl.NumberFormat('id-ID').format(finalTotal));
        }

        // Ketika checkbox ongkir dipilih
        $(document).on('change', '.ongkir-option', function() {
            updateTotalPrice();
        });

        // Menyimpan ongkir yang dipilih ke dalam input hidden sebelum form disubmit
        $('form').submit(function() {
            const selectedOngkir = [];
            $('.ongkir-option:checked').each(function() {
                selectedOngkir.push($(this).val());
            });
            $('#ongkir-hidden').val(selectedOngkir.join(','));

            // Menyimpan total harga akhir dalam input hidden
            $('#total-price-hidden').val($('#final-total').text().replace('Rp ', '').replace('.', '').trim());
        });
    </script>
</body>
</html>
