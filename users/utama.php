<?php
    include "koneksi.php";
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
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
							<div id="colorlib-logo"><a href="index_user.php"></a></div>
							<a href="index_user.php"><img alt="Starpowers logo" src="assets/logo/logo hitam sp full.png"></a>
						</div>
						<div class="col-sm-5 col-md-3">
			            <form action="#" class="search-wrap">
			               <div class="form-group">
			                  <input type="search" class="form-control search" placeholder="Search">
			                  <button class="btn btn-primary submit-search text-center" type="submit"><i class="icon-search"></i></button>
							  <div class="col-sm-12 text-right profile-menu">
        <ul>
            
        </ul>
    </div>
			               </div>
			            </form>
			         </div>
		         </div>
				 <?php
// Periksa halaman aktif dari parameter URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<div class="row">
    <div class="col-sm-12 text-left menu-1">
        <ul>
		<li class="has-dropdown <?php echo isset($_SESSION['username']) ? 'active' : ''; ?>">
								<a href="#">
									<i class="icon-user"></i> <!-- Ikon Profil -->
								</a>
								<ul class="dropdown">
									<li><a href="utama.php?page=profile"> Profil</a></li>
									<li><a href="logout.php">Logout</a></li>
								</ul>
							</li>
            <li class="<?php echo $page === 'home' ? 'active' : ''; ?>">
                <a href="index_user.php">Beranda</a>
            </li>
            <li class="has-dropdown <?php echo in_array($page, ['produk', 'produk_detail', 'keranjang', 'checkout']) ? 'active' : ''; ?>">
                <a href="utama.php?page=produk">Produk</a>
                <ul class="dropdown">
                    <li class="<?php echo $page === 'keranjang' ? 'active' : ''; ?>">
                        <a href="utama.php?page=keranjang">Keranjang</a>
                    </li>
                    <li class="<?php echo $page === 'checkout' ? 'active' : ''; ?>">
                        <a href="utama.php?page=checkout">Checkout</a>
                    </li>
                </ul>
            </li>
            <li class="<?php echo $page === 'about' ? 'active' : ''; ?>">
                <a href="utama.php?page=about">Tentang</a>
            </li>
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
    </a>
</li>

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
		<section class="content">
            <?php 
            if (isset($_GET['page'])) {
                if ($_GET['page'] == 'utama') { 
                    include "utama.php"; 
                } elseif ($_GET['page'] == 'logout') { 
                    include "logout.php"; 
                } elseif ($_GET['page'] == 'keranjang') { 
                    include "keranjang.php"; 
                }elseif ($_GET['page'] == 'about') { 
                    include "about.php"; 
                }elseif ($_GET['page'] == 'kategori') { 
                    include "kategori.php"; 
                }elseif ($_GET['page'] == 'index_user') { 
                    include "index_user.php"; 
                }elseif ($_GET['page'] == 'produk') { 
                    include "produk.php"; 
				}elseif ($_GET['page'] == 'produk_detail') { 
                    include "produk_detail.php"; 
                }elseif ($_GET['page'] == 'checkout') { 
                    include "checkout.php"; 
				}elseif ($_GET['page'] == 'tambah_keranjang') { 
                    include "tambah_keranjang.php";
				}elseif ($_GET['page'] == 'konfirmasi') { 
                    include "konfirmasi.php";
				}elseif ($_GET['page'] == 'profile') { 
                    include "profile.php";
				}elseif ($_GET['page'] == 'proses_checkout.php') { 
                    include "proses_checkout.php";
				}elseif ($_GET['page'] == 'sukses.php') { 
                    include "sukses.php";
                }
             }
            ?> 
        </section>
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
					</div>

					<div class="col footer-col">
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
<!-- Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a> -->
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

