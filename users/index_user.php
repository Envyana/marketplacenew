<?php
session_start();
include('koneksi.php'); // Sambungkan ke database

// Menambahkan produk ke keranjang
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $produk_id = $_GET['id'];
    $quantity = 1; // Jumlah barang yang dibeli

	// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Simpan halaman tujuan sebelum mengarahkan ke login
    $_SESSION['redirect_to'] = 'keranjang.php'; 
	$_SESSION['redirect_to'] = 'tambah_keranjang.php'; 
    header("Location: login.php");
    
}

    // Cek apakah keranjang sudah ada
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Jika produk sudah ada di keranjang, tambah jumlahnya
    if (isset($_SESSION['cart'][$produk_id])) {
        $_SESSION['cart'][$produk_id]['quantity'] += $quantity;
    } else {
        // Jika produk belum ada di keranjang, tambahkan
        $stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
        $stmt->bind_param("i", $produk_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $produk = $result->fetch_assoc();
            $_SESSION['cart'][$produk_id] = array(
                'name' => $produk['nama_produk'],
                'price' => $produk['harga'],
                'quantity' => $quantity
            );
        }
		// Jika belum login, arahkan ke halaman login
        header("Location: login.php");
    }
    header("Location: index_user.php"); // Kembali ke halaman utama setelah menambahkan produk
    exit();

}
?>
<!DOCTYPE HTML>
<html>
	<head>
	<title>Starpowers Marketplace</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="shortcut icon" type="image/x-icon" href="assets/logo/logo warna sp.png" />
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Rokkitt:100,300,400,700" rel="stylesheet">



	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Ion Icon Fonts-->
	<link rel="stylesheet" href="css/ionicons.min.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">

	<!-- Flexslider  -->
	<link rel="stylesheet" href="css/flexslider.css">

	<!-- Owl Carousel -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	
	<!-- Date Picker -->
	<link rel="stylesheet" href="css/bootstrap-datepicker.css">
	<!-- Flaticons  -->
	<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

	<!-- Theme style  -->
	<link rel="stylesheet" href="css/style.css">

	</head>
	<body>
		
	<div class="colorlib-loader"></div>

	<div id="page">
		<nav class="colorlib-nav" role="navigation">
			<div class="top-menu">
				<div class="container">
					<div class="row">
						<div class="col-sm-7 col-md-9">
							<div id="colorlib-logo"><a href="index)user.hphp"></a></div>
							<a href="index_user.php"><img alt="Starpowers logo" src="assets/logo/logo hitam sp full.png"></a>
						</div>
						<div class="col-sm-5 col-md-3">
			            <form action="#" class="search-wrap">
			               <div class="form-group">
			                  <input type="search" class="form-control search" placeholder="Search">
			                  <button class="btn btn-primary submit-search text-center" type="submit"><i class="icon-search"></i></button>
			               </div>
			            </form>
			         </div>
		         </div>
					<div class="row">
						<div class="col-sm-12 text-left menu-1">
							<ul>
							<li class="has-dropdown <?php echo isset($_SESSION['username']) ? 'active' : ''; ?>">
    <a href="#">
        <i class="icon-user"></i> <!-- Ikon Profil -->
    </a>
    <ul class="dropdown">
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="utama.php?page=profile">Profil</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</li>


								<li class="active"><a href="index_user.php">Beranda</a></li>
								<li class="has-dropdown">
									<a href="utama.php?page=produk">Produk</a>
									<ul class="dropdown">
										<li><a href="utama.php?page=keranjang">Keranjang</a></li>
										<li><a href="utama.php?page=checkout">Checkout</a></li>
									</ul>
								</li>
								<li><a href="utama.php?page=about">Tentang</a></li>
								<li class="has-dropdown">
									<a>Kategori</a>
									<ul class="dropdown">
										<li><a href="utama.php?page=kategori&id_kategori=7">Pakaian</a></li>
										<li><a href="utama.php?page=kategori&id_kategori=8">Tas</a></li>
									</ul>
								</li>
								<li class="cart <?php echo $page === 'keranjang' ? 'active' : ''; ?>">
    <a href="<?php echo isset($_SESSION['username']) ? 'utama.php?page=keranjang' : 'login.php'; ?>">
        <i class="icon-shopping-cart"></i> 
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="sale">
				<div class="container">
					<div class="row">
						<div class="col-sm-8 offset-sm-2 text-center">
							<div class="row">
								<div class="owl-carousel2">
									<div class="item">
										<div class="col">
											<h3><a href="#"></a></h3>
										</div>
									</div>
									<div class="item">
										<div class="col">
											<h3><a href="#"></a></h3>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
	
		<!-- <div class="colorlib-intro">
			<div class="container">
				
			</div>
		</div> -->
		
		<div class="banner-container">
    <!-- Banner 1 -->
    <div class="banner">
        <img src="assets/logo/banner.png" alt="Banner 1" class="banner-img">
    </div>

	<br>
	<br>
        <div class="colorlib-produk">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-2 text-center colorlib-heading">
                <h2>Produk Terlaris</h2>
            </div> 
        </div>
		<div class="row">
			<br>
    <?php
    // Query untuk mengambil data produk
    $stmt = $conn->prepare("SELECT * FROM produk LIMIT 6");
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah ada produk yang ditemukan
    if ($result->num_rows > 0) {
        // Loop untuk menampilkan produk
        while ($produk = $result->fetch_assoc()) {
            $product_image = $produk['gambar'];
            $warna = $produk['warna'];
            $ukuran = $produk['ukuran'];
            echo '<div class="col-md-4">
                    <div class="produk">
                        <img src="../upload/' . htmlspecialchars($product_image) . '" class="card-img-top product-image" alt="' . htmlspecialchars($produk['nama_produk']) . '">
                        <h3>
                            <a href="utama.php?page=produk_detail&id=' . $produk['id_produk'] . '">' . htmlspecialchars($produk['nama_produk']) . '</a>
                        </h3>
                        <span class="price">Rp ' . number_format($produk['harga'], 0, ',', '.') . '</span>
                        <p><strong>Warna: </strong>' . htmlspecialchars($warna) . '</p>
                        <p><strong>Ukuran: </strong>' . htmlspecialchars($ukuran) . '</p>
                        <a href="tambah_keranjang.php?action=add&id=' . $produk['id_produk'] . '" class="btn btn-primary">Tambah ke Keranjang</a>
                    </div>
                </div>';
        }
    } else {
        echo '<p>Produk tidak ditemukan.</p>';
    }
    ?>
</div>
<div class="row"></div>
</div>

<style>
/* Gaya utama untuk gambar produk */
.product-image {
    width: 100%;
    height: 250px;
    object-fit: cover;
    object-position: center;
    border-radius: 8px;
}

/* Gaya utama untuk card produk */
.produk {
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 12px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.produk:hover {
    transform: translateY(-8px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Gaya untuk teks deskripsi produk */
.produk p {
    margin: 10px 0;
    font-size: 15px;
    color: #444;
    line-height: 1.6;
}

/* Gaya untuk teks tebal */
.produk p strong {
    font-weight: bold;
    color: #000066;
}

/* Gaya untuk tombol */
.produk .btn {
    background-color: #000066;
    color: #fff;
    padding: 10px 15px;
    font-size: 14px;
    border-radius: 5px;
    text-align: center;
    transition: background-color 0.3s ease;
}

.produk .btn:hover {
    background-color: #333399;
    color: #f9f9f9;
}

/* Media query untuk responsif */
@media (max-width: 768px) {
    .produk {
        padding: 15px;
    }

    .product-image {
        height: 200px;
    }

    .produk p {
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .produk {
        margin-bottom: 15px;
        padding: 10px;
    }

    .product-image {
        height: 180px;
    }

    .produk p {
        font-size: 13px;
    }
}

/* Grid layout untuk produk */
.produk-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
    margin: 0 auto;
}

/* Layout untuk kontainer utama */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}
</style>


</div>

<style>
/* Atur ukuran gambar produk */
.product-image {
    width: 100%; /* Lebar gambar mengikuti lebar container */
    height: 250px; /* Tentukan tinggi gambar */
    object-fit: cover; /* Pastikan gambar tetap proporsional dan terpotong dengan baik jika tidak sesuai ukuran */
    object-position: center; /* Agar gambar tetap terpusat */
}

/* Gaya untuk card produk */
.produk {
    margin-bottom: 30px;
}
</style>

        <div class="row">
            <div class="col-md-12 text-center">
                <p><a href="utama.php?page=produk" class="btn btn-primary btn-lg">Shop All produks</a></p>
            </div>
        </div>
    </div>
</div>

		<footer id="colorlib-footer" role="contentinfo">
			<div class="container">
				<div class="row row-pb-md">
					<div class="col footer-col colorlib-widget">
						<h4>Tentang Kami</h4>
						<p>Selamat datang di Starpowers Marketplace, tempat di mana kecantikan bertemu dengan kemudahan belanja! Dengan slogan kami, "Belanja Seru, Berkilau Seperti Bintang," kami hadir untuk membantu Anda menemukan kilau terbaik dalam diri Anda.						</p>
						<p>
							<ul class="colorlib-social-icons">
								<li><a href="#"><i class="icon-twitter"></i></a></li>
								<li><a href="#"><i class="icon-facebook"></i></a></li>
								<li><a href="#"><i class="icon-linkedin"></i></a></li>
								<li><a href="#"><i class="icon-dribbble"></i></a></li>
							</ul>
						</p>
					</div>
					<!-- <div class="col footer-col colorlib-widget">
						<h4>Customer Care</h4>
						<p>
							<ul class="colorlib-footer-links">
								<li><a href="#">Contact</a></li>
								<li><a href="#">Returns/Exchange</a></li>
								<li><a href="#">Gift Voucher</a></li>
								<li><a href="#">Wishlist</a></li>
								<li><a href="#">Special</a></li>
								<li><a href="#">Customer Services</a></li>
								<li><a href="#">Site maps</a></li>
							</ul>
						</p>
					</div> -->
					<!-- <div class="col footer-col colorlib-widget">
						<h4>Information</h4>
						<p>
							<ul class="colorlib-footer-links">
								<li><a href="#">About us</a></li>
								<li><a href="#">Delivery Information</a></li>
								<li><a href="#">Privacy Policy</a></li>
								<li><a href="#">Support</a></li>
								<li><a href="#">Order Tracking</a></li>
							</ul>
						</p>
					</div> -->

					<!-- <div class="col footer-col">
						<h4>News</h4>
						<ul class="colorlib-footer-links">
							<li><a href="blog.html">Blog</a></li>
							<li><a href="#">Press</a></li>
							<li><a href="#">Exhibitions</a></li>
						</ul>
					</div> -->

					<div class="col footer-col">
						<h4>Informasi Kontak</h4>
						<ul class="colorlib-footer-links">
							<li>Sariasih Blok 3 No 9 <br>Bandung 40151</li>
							<li><a href="tel://1234567920">+62 823 2049 2916</a></li>
							<li><a href="mailto:info@yoursite.com">starpowers@gmail.com</a></li>
							<li><a href="#">starpowers marketplace.com</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="copy">
				<div class="row">
					<div class="col-sm-12 text-center">
						<p>
							<span><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></span> 
							<span class="block">Demo Images: <a href="http://unsplash.co/" target="_blank">Unsplash</a> , <a href="http://pexels.com/" target="_blank">Pexels.com</a></span>
						</p>
					</div>
				</div>
			</div>
		</footer>
	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a>
	</div>
	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
   <!-- popper -->
   <script src="js/popper.min.js"></script>
   <!-- bootstrap 4.1 -->
   <script src="js/bootstrap.min.js"></script>
   <!-- jQuery easing -->
   <script src="js/jquery.easing.1.3.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Flexslider -->
	<script src="js/jquery.flexslider-min.js"></script>
	<!-- Owl carousel -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- Magnific Popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/magnific-popup-options.js"></script>
	<!-- Date Picker -->
	<script src="js/bootstrap-datepicker.js"></script>
	<!-- Stellar Parallax -->
	<script src="js/jquery.stellar.min.js"></script>
	<!-- Main -->
	<script src="js/main.js"></script>

	</body>
</html>

