<?php
session_start(); // Mulai session di awal file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Seller Starpowers</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="logo warna sp.png" />
    <!-- Template CSS -->
    <link href="../assets/css/main.css?v=1.1" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="screen-overlay"></div>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="dashboard.php" class="brand-wrap">
                <img src="logo biru sp full.png" class="logo" alt="Starpowers" />
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize"><i class="text-muted material-icons md-menu_open"></i></button>
            </div>
        </div>
        <nav>
            <ul class="menu-aside">
                <li class="menu-item">
                    <a class="menu-link" href="utamapenjual.php?page=dashboard">
                        <i class="icon material-icons md-home"></i>
                        <span class="text">Beranda</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="utamapenjual.php?page=product">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Produk</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="utamapenjual.php?page=order">
                    <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">Pesanan</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="utamapenjual.php?page=transaksi">
                    <i class="icon material-icons md-monetization_on"></i>
                        <span class="text">Transaksi</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="utamapenjual.php?page=ulasan">
                    <i class="icon material-icons md-comment"></i>
                        <span class="text">Ulasan</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="searchform">
                    <div class="input-group">
                        <input list="search_terms" type="text" class="form-control" placeholder="Search term" />
                        <button class="btn btn-light bg" type="button"><i class="material-icons md-search"></i></button>
                    </div>
                    <datalist id="search_terms">
                        <option value="Products"></option>
                        <option value="New orders"></option>
                        <option value="Apple iphone"></option>
                        <option value="Ahmed Hassan"></option>
                    </datalist>
                </form>
            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"><i class="material-icons md-apps"></i></button>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link btn-icon" href="#">
                            <i class="material-icons md-notifications animation-shake"></i>
                            <span class="badge rounded-pill">3</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-icon darkmode" href="#"><i class="material-icons md-nights_stay"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="requestfullscreen nav-link btn-icon"><i class="material-icons md-cast"></i></a>
                    </li>
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount" aria-expanded="false"><img class="img-xs rounded-circle" src="../assets/imgs/people/avatar-2.png" alt="User" /></a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                                <a class="dropdown-item text-danger" href="logoutpenjual.php"><i class="material-icons md-exit_to_app"></i>Logout</a>
                  </div>
                    </li>
                </ul>
            </div>
        </header>
        <section class="content">
            <?php
            if (isset($_GET['page'])) {
                if ($_GET['page'] == 'utama') { 
                    include "utamapenjual.php"; 
                } elseif ($_GET['page'] == 'logout') { 
                    include "logout.php"; 
                } elseif ($_GET['page'] == 'dashboard') { 
                    include "dashboard.php"; 
                } elseif ($_GET['page'] == 'categories') { 
                    include "categories.php"; 
                } elseif ($_GET['page'] == 'addcategories') { 
                    include "addcategories.php"; 
                } elseif ($_GET['page'] == 'editcategories') { 
                    include "editcategories.php"; 
                } elseif ($_GET['page'] == 'deletecategories') { 
                    include "deletecategories.php"; 
                } elseif ($_GET['page'] == 'product') { 
                    include "product.php";
                } elseif ($_GET['page'] == 'addproduct') { 
                    include "addproduct.php"; 
                } elseif ($_GET['page'] == 'editproduct') { 
                    include "editproduct.php"; 
                } elseif ($_GET['page'] == 'deleteproduct') { 
                    include "deleteproduct.php"; 
                } elseif ($_GET['page'] == 'order') { 
                    include "order.php"; 
                } elseif ($_GET['page'] == 'detailorder') { 
                    include "detailorder.php"; 
                }  elseif ($_GET['page'] == 'transaksi') { 
                    include "transaksi.php"; 
                }  elseif ($_GET['page'] == 'transaksidetail') { 
                    include "transaksidetail.php"; 
                }  elseif ($_GET['page'] == 'ulasan') { 
                    include "ulasan.php"; 
                } 
            }
            ?> 
        </section>

        <footer class="main-footer font-xs">
            <div class="row pb-30 pt-15">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear());
                    </script>
                    &copy; Manik La Magie
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end">All rights reserved</div>
                </div>
            </div>
        </footer>
    </main>

    <script src="../assets/js/vendors/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/vendors/select2.min.js"></script>
    <script src="../assets/js/vendors/perfect-scrollbar.js"></script>
    <script src="../assets/js/vendors/jquery.fullscreen.min.js"></script>
    <script src="../assets/js/vendors/chart.js"></script>
    <script src="../assets/js/main.js?v=1.1"></script>
    <script src="../assets/js/custom-chart.js"></script>
</body>
</html>
