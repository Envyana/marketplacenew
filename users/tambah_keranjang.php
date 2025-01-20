<?php
session_start();
include('koneksi.php');

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil id_produk dari GET atau POST
$id_produk = isset($_POST['id_produk']) ? intval($_POST['id_produk']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);
$quantity = 1; // Default jumlah

if ($id_produk <= 0) {
    die("ID produk tidak valid.");
}

// Periksa koneksi database
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Periksa apakah produk valid
$stmt = $conn->prepare("SELECT * FROM produk WHERE id_produk = ?");
$stmt->bind_param("i", $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Produk tidak ditemukan.");
}

$produk = $result->fetch_assoc();

// Periksa apakah produk sudah ada di keranjang
$stmt = $conn->prepare("SELECT id_keranjang, quantity FROM cart WHERE username = ? AND id_produk = ?");
$stmt->bind_param("si", $username, $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Jika produk sudah ada, perbarui jumlah
    $row = $result->fetch_assoc();
    $new_quantity = $row['quantity'] + $quantity;

    $update_stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id_keranjang = ?");
    $update_stmt->bind_param("ii", $new_quantity, $row['id_keranjang']);
    $update_stmt->execute();
} else {
    // Jika produk belum ada, tambahkan ke keranjang
    $insert_stmt = $conn->prepare("INSERT INTO cart (username, id_produk, quantity, created_at) VALUES (?, ?, ?, NOW())");
    $insert_stmt->bind_param("sii", $username, $id_produk, $quantity);
    $insert_stmt->execute();
}

// Redirect kembali ke halaman keranjang
header("Location: utama.php?page=keranjang");
exit();
?>
